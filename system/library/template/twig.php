<?php
namespace Template;
final class Twig {
	private $data = array();

	public function set($key, $value) {
		$this->data[$key] = $value;
	}
	
	public function render($filename, $code = '') {
		if (!$code) {
			$file = DIR_TEMPLATE . $filename . '.twig';

			if (is_file($file)) {
				$code = file_get_contents($file);
			} else {
				throw new \Exception('Error: Could not load template ' . $file . '!');
				exit();
			}
		}

		// Normalize root-relative asset/route URLs and batch padding in memory without modifying template files on disk
		$code = str_replace(
			array(
				'"/application/',
				"'/application/",
				'(/application/',
				'"/image/',
				"'/image/",
				'(/image/',
				'"/index.php',
				"'/index.php",
				"|batch(3, '')",
				"|batch(2, '')",
				"|batch(6, '')",
				'<div class="row"> {% for showcase in showcases %}',
				"location = '{{ type.href }}'"
			),
			array(
				'"application/',
				"'application/",
				'(application/',
				'"image/',
				"'image/",
				'(image/',
				'"index.php',
				"'index.php",
				"|batch(3)",
				"|batch(2)",
				"|batch(6)",
				'<div class="row"> {% for showcase in row %}',
				"location = '{{ partner_type.href }}'"
			),
			$code
		);

		// initialize Twig environment
		$config = array(
			'autoescape'  => false,
			'debug'       => false,
			'auto_reload' => true,
			'cache'       => DIR_CACHE . 'template/'
		);

		try {
			$loader = new \Twig\Loader\ArrayLoader(array($filename . '.twig' => $code));

			$twig = new \Twig\Environment($loader, $config);

			return $twig->render($filename . '.twig', $this->data);
		} catch (Exception $e) {
			trigger_error('Error: Could not load template ' . $filename . '!');
			exit();
		}	
	}	
}
