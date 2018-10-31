<?php 
	//require_once("/config.php");

	set_error_handler('error_handler');
	set_exception_handler('error_handler');
	function error_handler($errno, $errmsg, $filename, $linenum) {
		$date = date('Y-m-d H:i:s (T)');
		$f = fopen('errors.log', 'a');
		if (!empty($f)) {
			$filename  = str_replace($_SERVER['DOCUMENT_ROOT'],'',$filename);
			$err  = "$date"."  Error: "."$errmsg $filename $linenum\r\n";
			fwrite($f, $err);
			fclose($f);
		}
	}

	abstract class core {


		protected $db;

		public function __construct() {
			$this->db = new PDO('mysql:host=localhost;dbname=project;charset=utf8', 'root', '');

			if(!$this->db) {
				//Не удалось подключиться к Базе Данных
				header("Location: error.php");
			}
		}

		protected function getHeader() {
			 include "header.php";
		}

		protected function getContent() {

			#CATEGORIES
			$result_categories = $this->db->query("SELECT * FROM categories");
			if(!$result_categories) {
				//Ошибка не удалось получить данные из таблицы categories
				header("Location: error.php");
			}

			$row_categories = array();
			echo "
			<section class='cd-faq'>
				<ul class='cd-faq-categories'>";
			$row_categories = $result_categories->fetchAll(PDO::FETCH_ASSOC);
			for ($i = 0; $i < $result_categories->rowCount(); $i++) {
				printf("<li><a href='%s'>%s</a></li>", $row_categories[$i]['id_category'], $row_categories[$i]['title']);
			}
			echo "
				</ul>";

			#QUESTIONS
			$result_questions = $this->db->query("SELECT * FROM questions");
			if(!$result_questions) {
				//Ошибка не удалось получить данные из таблицы questions
				header("Location: error.php");
			}

			$row_questions = array();
			echo "
			<div class='cd-faq-items'>
				<ul id='basics' class='cd-faq-group'>
					<li class='cd-faq-title'><h2>Category 1</h2></li>
			";
			$row_questions = $result_questions->fetchAll(PDO::FETCH_ASSOC);
			for ($i = 0; $i < $result_questions->rowCount(); $i++) {
				echo "<li>";
					printf("<a class='cd-faq-trigger' href='#0'>%s</a>", $row_questions[$i]['title']);
					echo "<div class='cd-faq-content'>";
					printf("<p>%s</p>", $row_questions[$i]['text']);
					echo "</div>";
				echo "</li>";
			}
				
			



		}

		protected function getFooter() {
			echo "
					<a href='#0' class='cd-close-panel'></a>
				</section> <!-- cd-faq -->
				<script src='js/jquery-2.1.1.js'></script>
				<script src='js/jquery.mobile.custom.min.js'></script>
				<script src='js/main.js'></script> <!-- Resource jQuery -->
			";
		}

		public function get_body() {
			 $this->getHeader();
			 $this->getContent();
			 $this->getFooter();
			 
		}
	}

?>