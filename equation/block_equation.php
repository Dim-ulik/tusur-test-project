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

    function checkInput($a, $b, $c) {
        if (is_numeric($a) && is_numeric($b) && is_numeric($c)) {
            if ($a !== 0) {
                return true;
            }
        }
        return false;
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

        if (!$this->checkInput($a, $b, $c)) {
            $_SESSION['equation_error'] = true;
            header('Location: ' . $this->page->url);
            return;
        }

        if ($DB->insert_record('block_equation_table', $record)) {
            $_SESSION['equation_solver'] = true;
            header('Location: ' . $this->page->url);
        }
    }

    function showTheLastResult() {
        global $DB;
        $sql = "SELECT * FROM mdl_block_equation_table ORDER BY id DESC LIMIT 1";
        $lastResult = $DB->get_record_sql($sql);
        if (!$lastResult) {
            return;
        }

        $res1 = $lastResult->res1;
        $res2 = $lastResult->res2;

        $this->content->text .= "<div><div>Последнее решение:</div>";
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
        $_SESSION['equation_solver'] = false;
    }

    function showError() {
        $this->content->text .= "<div class='error_message'>Ошибка введенных данных!</div>";
    }

    function showTheInfAfterSolving() {
        if (isset($_SESSION['equation_error'])) {
            if ($_SESSION['equation_error'] === true) {
                $this->showError();
                $_SESSION['equation_error'] = false;
                return;
            }
        }
        if (isset($_SESSION['equation_solver'])) {
            if ($_SESSION['equation_solver'] === true) $this->showTheLastResult();
        }
    }

    public function get_content() {
        if ($this->content !== null) {
            return $this->content;
        }

        $this->content = new stdClass;
        $this->content->text .= "<div class='block-body'>";
        $this->content->text .= "<div class='name'>Решение квадратного уравнения</div>";
        $this->content->text .= "<form method='post' class='form-body'>";
        $this->content->text .= "<div id='errors-container'></div>";
        $this->content->text .= "<div class='k-block'><span class='letter'>a =</span><input type='text' name='a-inp' placeholder='введите значение...' class='input' id='a' required></div>";
        $this->content->text .= "<div class='k-block'><span class='letter'>b =</span><input type='text' name='b-inp' placeholder='введите значение...' class='input' id='b' required></div>";
        $this->content->text .= "<div class='k-block'><span class='letter'>c =</span><input type='text' name='c-inp' placeholder='введите значение...' class='input' id='c' required></div>";
        $this->content->text .= "<button class='submit-button' id='btn-submit' disabled='true'>Найти решение</button>";
        $this->content->text .= "</form>";
        $this->content->text .= "
    <script>
        const a_elem = document.getElementById('a');
        const b_elem = document.getElementById('b');
        const c_elem = document.getElementById('c');
        const errorsContainer = document.getElementById('errors-container');
        const submitButton = document.getElementById('btn-submit');
        
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
                errorsContainer.innerText = '';
                submitButton.removeAttribute('disabled');
            }
            else {
                errorsContainer.innerText = 'Введите корректные данные!';
                submitButton.setAttribute('disabled', true);
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

        $this->showTheInfAfterSolving();

        $this->content->text .= "<div><a href='" . $this->page->url . "blocks/equation/pages/table_results.php' class='a-class'>Показать историю решений</a></div>";
        $this->content->text .= "</div>";

        if (isset($_POST["a-inp"])) {
            $this->solver($_POST["a-inp"], $_POST["b-inp"], $_POST["c-inp"]);
        }
    }
}

