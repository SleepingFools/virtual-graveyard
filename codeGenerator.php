<?php
class codeGenerator {

    static public function generateMenu() {
        $result = '
            <div class="menu">
                <ul>
                    <li><h2 class="menu-title">Menu</h2></li>';
        if ($_SESSION["user_is_logged"] == 1) {
            $result .= '<li><a href="logout.php">Log out</a></li>';
            if ($_SESSION["user_is_relative"] == 1) {
                $result .= '<li><a href="dRegister.php">Register a deceased person</a></li>';
            }
            if ($_SESSION["user_is_admin"] == 1) {
                $result .= '<li><a href="eRegister.php">Register a new employee</a></li>
                <li><a href="register.php">Register a new Relative</a></li>';
            }
        }
        else {
            $result .= '
            <li><a href="login.php">Log in</a></li>
            <li><a href="register.php">Register</a></li>';
        }
        $result .= '<li><a href="index.php">Search Graveyard</a></li>
                </ul>
            </div>';
        return $result;
    }
}
?>