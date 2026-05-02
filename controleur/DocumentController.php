<?php
class DocumentController {
    public function show() {
        $pageTitle = "Documentation";
        include __DIR__ . "/../vue/documentation.php";
    }
}
