<?php
class TestController
{
    public function test()
    {
        require_once "../Models/RecipeModel.php";
        $t = new RecipeModel();
        print_r($t->getLastRecipeID($_SESSION['UUID']));
    }
}
