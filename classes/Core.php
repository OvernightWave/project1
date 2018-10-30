<?php 
	//require_once("/config.php");

	abstract class Core {


		protected $db;

		public function __construct() {
			$this->db = new PDO('mysql:host=localhost;dbname=project;charset=utf8', 'root', '');

			if(!$this->db) {
				exit("Не удалось подключиться к Базе Данных.");
			}
		}

		protected function get_header() {
			 include "header.php";
		}

		protected function get_content() {

			#CATEGORIES
			$result_categories = $this->db->query("SELECT * FROM categories");
			if(!$result_categories) {
				exit("Ошибка!");
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
				exit("Ошибка!");
			}

			$row_questions = array();
			echo "
			<div class='cd-faq-items'>
				<ul id='basics' class='cd-faq-group'>
					<li class='cd-faq-title'><h2>Category 1</h2></li>
					<li>
			";
			$row_questions = $result_questions->fetchAll(PDO::FETCH_ASSOC);
			for ($i = 0; $i < $result_questions->rowCount(); $i++) {
				printf("<a class='cd-faq-trigger' href='#0'>%s</a>", $row_questions[$i]['title']);
				echo "<div class='cd-faq-content'>";
				printf("<p>%s</p>", $row_questions['text']);
				echo "</div>";
			}
			echo "</li>";
			echo "</section";



		}

		public function get_body() {
			 $this->get_header();
			 $this->get_content();
			 
		}
	}

?>