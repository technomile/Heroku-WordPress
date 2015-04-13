<?php
require 'plugin/updater.php';
require 'plugin/options-framework/options-framework.php';

if (file_exists(dirname(__FILE__) . '/../ft-options.php'))
	require_once dirname(__FILE__) . '/../ft-options.php';

class FT_scope
{
	private static $im;
	public $updater;
	public $theme;
	public $themeName;
	public $optionsName;
	public $wpVersion;

	// Инициализация
	// Определение основных переменных и запуск базовых функций
	static public function init()
	{
		self::$im = new FT_scope;

		self::$im->theme = wp_get_theme();

		// Переводим № версии в число: 3.8.3 -> 3.8
		self::$im->wpVersion = floatval(get_bloginfo('version'));

		self::$im->themeName = self::$im->theme->get('Name');
		self::$im->optionsName = preg_replace("/\W/", "_", strtolower(self::$im->themeName));

		// Запускаем класс обновления темы
		self::$im->updater = new FT_ThemeUpdateChecker(
				 // Папка темы
				 self::$im->themeName,
				 // json-URL информация о текущей версии темы на сервере
				'http://www.fabthemes.com/versions/' . strtolower(str_replace(' ', '-', self::$im->themeName)) . '.json'
		);

		// Включаем все хуки для wordpress
		self::$im->anchors();
	}

	static public function tool()
	{
		return self::$im;
	}

	public static function wp_enqueue_scripts ()
	{
		wp_register_script('Bootstrapcdn.js', '//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js', array('jquery'), 1);
		wp_enqueue_script('Bootstrapcdn.js');
		wp_register_style('Bootstrapcdn.css', '//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css', array(), 1);
		wp_enqueue_style('Bootstrapcdn.css');
	}

	/* Хуки для Wordpress */
	private function anchors()
	{
		add_action('admin_head', array(self::$im, 'addUpgradeButton'));

		// Передаём в js название темы (надо для работы опций)
		add_action('admin_head', array(self::$im, 'echoAdminHeadScript'));

		// Передаём в js название темы (надо для работы опций)
		add_action('wp_footer', array(self::$im, 'echoClientScript'));

		// Добавляем функционал в меню "/wp-admin/customize.php"
		add_action('customize_register', array(self::$im, 'themeCustomize'));

		// Включено для совместимости со старыми темами
		# add_action( 'wp_enqueue_scripts', array($this, 'wp_enqueue_scripts') );
	}

	/* Добавляем опции в редактор тем
	 */
	public static function themeCustomize($wp_customize)
	{
		$sectionId = self::$im->optionsName . 'logoUploadID_';

		// Section: Upload Logo
				$wp_customize->add_section($sectionId , array(
						'title'       => __( 'Site Logo', 'themeslug' ),
						'priority'    => 1,
						'description' => 'Upload a logo to replace the default site name',
				));
				// Upload
				$wp_customize->add_setting(self::$im->optionsName . '_logo');
				$wp_customize->add_control( new WP_Customize_Image_Control($wp_customize, self::$im->optionsName . '_logo', array(
						'label'    => __( '', 'themeslug' ),
						'section'  => $sectionId,
						'settings' => self::$im->optionsName . '_logo',
				)));
				// Max width
				$wp_customize->add_setting(self::$im->optionsName . '_maxWidth', array('default' => 100));
				$wp_customize->add_control( new WP_Customize_Control($wp_customize, self::$im->optionsName . '_maxWidth',
								array(
										'label'          => __('Maximum width (px)', self::$im->optionsName),
										'section'        => $sectionId,
										'settings'       => self::$im->optionsName . '_maxWidth',
										'type'           => 'text',
				)));
				// Max height
				$wp_customize->add_setting(self::$im->optionsName . '_maxHeight', array('default' => 55));
				$wp_customize->add_control( new WP_Customize_Control($wp_customize, self::$im->optionsName . '_maxHeight',
								array(
										'label'          => __('Maximum height (px)', self::$im->optionsName),
										'section'        => $sectionId,
										'settings'       => self::$im->optionsName . '_maxHeight',
										'type'           => 'text',
				)));
	}

	/* Ф-я выводит js script в каждую стр. темы (в админке)
	 */
	public function echoAdminHeadScript()
	{
		echo '<script type="text/javascript">';
		echo 'var themeName = "' . self::$im->optionsName . '";';
		echo 'var elLogo = document.getElementById("ft_logo"); if (elLogo) {elLogo.style.maxHeight = elLogo.getAttribute("relHeight") ? elLogo.getAttribute("relHeight") + "px" : "100px";} if (elLogo) {elLogo.style.maxWidth = elLogo.getAttribute("relWidth") ? elLogo.getAttribute("relWidth") + "px" : "100px";}';
		echo '</script>';
	}

	/* Ф-я выводит js script в каждую стр. темы (всем пользователям)
	 */
	public function echoClientScript()
	{
		echo '<script type="text/javascript">';
		echo 'var elLogo = document.getElementById("ft_logo"); if (elLogo) {elLogo.style.maxHeight = elLogo.getAttribute("relHeight") ? elLogo.getAttribute("relHeight") + "px" : "100px";} if (elLogo) {elLogo.style.maxWidth = elLogo.getAttribute("relWidth") ? elLogo.getAttribute("relWidth") + "px" : "100px";}';
		echo '</script>';
	}

	/* Ф-я обновляем css из Less
	 */
	public static function afterOptionsUpdate($newOptions = array())
	{
		if (!file_exists(dirname(__FILE__) . '/../css/theme.less'))
				return;

		require_once 'inc/lessc.php';
		$less = new lessc();

		$styleFile = dirname(__FILE__) . '/../css/theme.css';
		$lessFile = dirname(__FILE__) . '/../css/theme.less';

		// Применяем цвета
		$less->setVariables(array(
				'color1' => $newOptions['colorset1'],
				'color2' => $newOptions['colorset2'],
				'color3' => $newOptions['colorset3'],
				'color4' => $newOptions['colorset4'],
				'color5' => $newOptions['colorset5'],
		));

		file_put_contents($styleFile, $less->compileFile($lessFile));
	}

	/* Ф-я добавляет в админку (окно выбора тем)
	 * кнопки для покупки коммерческой лицензии
	 */
	public function addUpgradeButton()
	{
		$themeName = str_replace(' ', '-', $this->themeName);

		// Butt in the popup description
		$popupButtText = 'Learn more about commercial license';
		// Butt in wp versions > 3.8 (main page)
		$buttText = 'Upgrade';
		// Text before button
		$textBeforeButt = 'Free wordpress theme for Non-commercial use.';

		// Similar
		$js = '';
		$_findTheme = '';
		$_findParentButt = '';
		$_buttParent = '<a target=\"_blank\" style=\"box-shadow: 0 1px 0 #68BE43 inset !important; border-color: #00A218; background-color: #35AE2D;\" class=\"buttBuyMe button button-primary\" href=\"https://fabthemes.com/order/license?theme='.$themeName.'&domain=' . $_SERVER['HTTP_HOST'] . '\">' . $buttText . '</a>';
		$_findOverlayButt = '';
		$_buttOverlay = '<a target=\"_blank\" id=\"ButtButMeDesc\" style=\"box-shadow: 0 1px 0 #68BE43 inset !important; border-color: #00A218; background-color: #35AE2D;\" class=\"buttBuyMe button button-primary\" href=\"https://fabthemes.com/order/license?theme='.$themeName.'&domain=' . $_SERVER['HTTP_HOST'] . '\">' . $popupButtText . '</a>';
		$_findOverlay = '';

		// Difference
		if ($this->wpVersion < 3.4) { /* 2, 2.5 */
		}
		elseif ($this->wpVersion <= 3.4) {
				$_findParentButt = '.action-links > ul';
				$_findTheme = 'jQuery("#availablethemes h3:contains(\'' . $this->themeName . '\')").closest(".available-theme")';
				$_findOverlayButt = 'jQuery("#current-theme h4:contains(\'' . $this->themeName . '\')").closest("#current-theme").find(".theme-info")';
				$_buttOverlay = '<div style=\"margin: 0 0 15px;\"><a target=\"_blank\" id=\"ButtButMeDesc\" style=\"padding: 8px 8px 8px 8px;\" class=\"buttBuyMe button button-primary\" href=\"https://fabthemes.com/order/license?theme='.$themeName.'&domain=' . $_SERVER['HTTP_HOST'] . '\">Buy Commercial Usage License</a></div>';
		}
		elseif ($this->wpVersion < 3.8) { /* 3.5, 3.6, 3.7 */
				$_findParentButt = '.action-links > ul';
				$_findOverlayButt = 'jQuery("#current-theme h4:contains(\'' . $this->themeName . '\')").closest("#current-theme").find(".theme-info")';
				$_buttOverlay = '<div style=\"margin: 15px 0 15px 0;\"><a target=\"_blank\" id=\"ButtButMeDesc\" class=\"buttBuyMe button button-primary\" href=\"https://fabthemes.com/order/license?theme='.$themeName.'&domain=' . $_SERVER['HTTP_HOST'] . '\">Buy Commercial Usage License</a></div>';
		}
		elseif ($this->wpVersion <= 3.9) {
				$_findParentButt = '.theme-actions';
				$_findTheme = 'jQuery(".themes > div[aria-describedby=\'' . $themeName . '-action ' . $themeName . '-name\']")';
				$_findOverlayButt = 'jQuery(".theme-wrap h3.theme-name:contains(\'' . $this->themeName . '\')")';
				$_buttOverlay = '<div style=\"margin: 10px 0 0;\">' . $_buttOverlay . '</div>';
				$textBeforeButt = '<div style=\"margin: 30px 0 0;\">' . $textBeforeButt . '</div>';
				$_findOverlay = '.theme[aria-describedby=\''.$themeName.'-action '.$themeName.'-name\'] > .theme-screenshot img, #'.$themeName.'-action, #'.$themeName.'-name, div[aria-describedby=\''.$themeName.'-action '.$themeName.'-name\'] .theme-actions';
		}

		// Main page butt "Upgrade"
		if ($this->wpVersion <= 3.9) {
			if (!empty($_findTheme) && !empty($_findParentButt) && !empty($_buttParent))
					$js .=
						 $_findTheme . '.each(function () {
								jQuery(this).find("' . $_findParentButt . '").append("' . $_buttParent . '");
								jQuery(".buttBuyMe").on("mouseover", function() { jQuery(this).css({"background-color":"#409A39", "border-color": "#558B51"}); });
								jQuery(".buttBuyMe").on("mouseout", function() { jQuery(this).css({"background-color":"#35AE2D", "border-color":"#00A218"}); });
					});';
		}

		// If overlay already open
		if (!empty($_findOverlayButt) && !empty($_buttOverlay))
			// Определяем текст - назв. темы в заголовке
			$js .= $_findOverlayButt . '.after("' . $textBeforeButt . $_buttOverlay . '");';

		// Overlay
		if (!empty($_findOverlay) && !empty($_buttOverlay))
			$js .= '
					// If overlay just opened + 1 sec. interval
					var timerId;
					jQuery("' . $_findOverlay . '").on("click", function() {
						timerId = setInterval(function() {
							if (' . $_findOverlayButt . '.length != 0) {
									' . $_findOverlayButt . '.after("' . $textBeforeButt . $_buttOverlay . '");
									jQuery("#ButtButMeDesc").fadeIn(250);
									clearInterval(timerId);
							}
						}, 200);
					});
		';

		$js .= '';

		echo '<script type="text/javascript">jQuery(window).load(function() {' . $js . '});</script>';
	}
}