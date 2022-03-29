<?php

class skill extends model
{
    private $skillsTable = 'skill';
    private $skillRequirementsTable = 'skillrequirement';
    private $metaRequirementsTypeTable = 'meta_requirementstype';
    private $metaSkillTargetTable = 'meta_skilltarget';
    private $metaSkillImpactTable = 'meta_skillimpact';

    public $ID;
    public $name;
    public $description;
    public $costs = ['hpCost' => null, 'mpCost' => null, 'staminaCost' => null, 'timeCost' => null];
    public $target;
    public $cooldown;
    public $duration;
    public $impact = ['impactType' => null, 'impactCount' => null];
    public $effectID = null;
    public $mainCharacteristic;
    public $blockCharacteristic = null;
    public $skillRequirementsID = null;
    public $skillRequirements = [['type' => 1, 'requirements' => ['weapon', 'sword']]];

    public function createSkill(){

    }

    public function deleteSkill(){

    }

    public function addRequirementsToSkill(){

    }

    public function removeRequirementsFromSkill(){

    }
}