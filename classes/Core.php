<?php 
	//require_once("/config.php");

	abstract class Core {


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
			$row_categories = $result_categories->fetchAll(PDO::FETCH_ASSOC);

			echo "
			<section class='cd-faq'>
				<ul class='cd-faq-categories'>";
			for ($i = 0; $i < $result_categories->rowCount(); $i++) {
				if ($i == 0) {
					printf("<li><a class='selected' href='#%s'>%s</a></li>", $row_categories[$i]['id_category'], $row_categories[$i]['title']);	
				}
				else {
					printf("<li><a href='#%s'>%s</a></li>", $row_categories[$i]['id_category'], $row_categories[$i]['title']);	
				}
			}
			echo "</ul>";

			#QUESTIONS
			$result_questions = $this->db->query("SELECT * FROM questions");
			if(!$result_questions) {
				//Ошибка не удалось получить данные из таблицы questions
				header("Location: error.php");
			}

			$row_questions = array();
			$row_questions = $result_questions->fetchAll(PDO::FETCH_ASSOC);

			echo "<div class='cd-faq-items'>";			
			for ($i = 0; $i < $result_categories->rowCount(); $i++) {
				printf("<a id='%s'></a>", $row_categories[$i]['id_category']);
				echo "<ul class='cd-faq-group'>";
				printf("<li class='cd-faq-title'><h2>%s</h2></li>",$row_categories[$i]['title']);
				for ($j = 0; $j < $result_questions->rowCount(); $j++) {
					if ($row_categories[$i]['id_category'] == $row_questions[$j]['id_category']) {
						echo "<li>";
							printf("<a class='cd-faq-trigger' href='#0'>%s</a>", $row_questions[$j]['title']);
							echo "<div class='cd-faq-content'>";
							printf("<p>%s</p>", $row_questions[$j]['text']);
							echo "</div>";
						echo "</li>";	
					}
				}
				echo "</ul>";
			}
			echo "</div>";
			


				
			



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

		public function getBody() {
			 $this->getHeader();
			 $this->getContent();
			 $this->getFooter();
			 
		}
	}

?>