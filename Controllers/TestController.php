<?php
class TestController
{
    /**
     * Fonction de test.
     * Elle est configurée dans "routes.php" pour être accessible via l'URL "/test".
     */
    public function test()
    {
        throw new Error("Test", 100);
    }
}
