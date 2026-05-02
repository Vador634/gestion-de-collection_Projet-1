<?php
// modele/Condition.php
class Condition {
    public $idCondition;
    public $libelleCondition;

    public function __construct($idCondition = null, $libelleCondition = null) {
        $this->idCondition = $idCondition;
        $this->libelleCondition = $libelleCondition;
    }
}
