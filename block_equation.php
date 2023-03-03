<?php

class block_equation extends block_base {
    function init() {
        global $CFG, $DB;
        $this->title = get_string('equation', 'block_equation');
    }

    function has_config() {
        return true;
    }

    function square($num) {
        return pow($num, 2);
    }

    function solver($a, $b, $c) {
        global $DB;
        $record = new stdClass();
        $record->a = $a;
        $record->b = $b;
        $record->c = $c;
        $d = $this->square($b) - 4*$a*$c;
        if ($d < 0) {
            $record->res1 = NULL;
            $record->res2 = NULL;
        }
        else {
            $record->res1 = (-$b + sqrt($d)) / (2*$a);
            $record->res2 = (-$b - sqrt($d)) / (2*$a);
        }
        $DB->insert_record('block_equation_table', $record);
    }

    public function get_content() {
        global $DB, $USER;
        if ($this->content !== null) {
            return $this->content;
        }

        $sql = "SELECT * FROM mdl_block_equation_table ORDER BY id DESC LIMIT 1" ;
        $lastResult = $DB->get_record_sql($sql);

        $this->content = new stdClass;
        $this->content->text .= "<div class='block-body'>";
        $this->content->text .= "<div class='name'>Решение квадратного уравнения</div>";
        $this->content->text .= "<form method='post' class='form-body'>";
        $this->content->text .= "<div id='errors-container'></div>";
        $this->content->text .= "<div class='k-block'><span class='letter'>a =</span><input type='text' name='a-inp' placeholder='введите значение...' class='input' id='a'></div>";
        $this->content->text .= "<div class='k-block'><span class='letter'>b =</span><input type='text' name='b-inp' placeholder='введите значение...' class='input' id='b'></div>";
        $this->content->text .= "<div class='k-block'><span class='letter'>c =</span><input type='text' name='c-inp' placeholder='введите значение...' class='input' id='c'></div>";
        $this->content->text .= "<button class='submit-button' id='btn-submit' disabled='true'>Найти решение</button>";
        $this->content->text .= "</form>";
        $this->content->text .= "
    <script>

        let a_elem = document.getElementById('a');
        let b_elem = document.getElementById('b');
        let c_elem = document.getElementById('c');
        
        function check() {
            let flag = 0;
            if (String(parseFloat(a_elem.value, 10)) !== String(a_elem.value) || a_elem.value === '0') {
                flag = 1;
            }
            if (String(parseFloat(b_elem.value, 10)) !== String(b_elem.value)) {
                flag = 1;
            }
            if (String(parseFloat(c_elem.value, 10)) !== String(c_elem.value)) {
                flag = 1;
            }
            return flag;
        }
        
        function after_checking() {
            if (!check()) {
                document.getElementById('errors-container').innerText = '';
                document.getElementById('btn-submit').removeAttribute('disabled');
            }
            else {
                document.getElementById('errors-container').innerText = 'Введите корректные данные!';
                document.getElementById('btn-submit').setAttribute('disabled', true);
            }
        }
        
        a_elem.oninput = function () {
            after_checking();
        }
            
        b_elem.oninput = function () {
            after_checking();
        }
        
        c_elem.oninput = function () {
            after_checking();
        }
    </script>";

        if (isset($_POST["a-inp"])) {
            $this->solver($_POST["a-inp"], $_POST["b-inp"], $_POST["c-inp"]);
            echo "<script>location.reload()</script>";
        }

        $res1 = $lastResult->res1;
        $res2 = $lastResult->res2;

        $this->content->text .= "<div><div>Решение:</div>";
        if ($res1 === NULL) {
            $this->content->text .= "<span>Решений нет!</span>";
        }
        else {
            if ($res1 === $res2) {
                $this->content->text .= "<span>x1 = x2 = {$res2}</span>";
            }
            else {
                $this->content->text .= "<div>x1 = {$res1}</div>";
                $this->content->text .= "<div>x2 = {$res2}</div>";
            }
        }

        $this->content->text .= "</div>";
        $this->content->text .= "<div><a href='" . $this->page->url . "blocks/equation/pages/table_results.php' class='a-class'>Показать историю решений</a></div>";
        $this->content->text .= "</div>";
    }
}

