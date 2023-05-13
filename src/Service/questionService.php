<?php

namespace App\Service;

use App\Entity\Question;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use PhpParser\Node\Expr\Cast\Array_;

class questionService
{
    private Array $questions ;
    private String $msg ;
    public function __construct()
    {
        $this->questions = [];
        $this->msg = "" ;
    }
    public function setExamenQuestion(Array $qts){
        $this->questions = $qts;
    }
    public function getExamenQuestion():Array{
        return $this->questions;
    }
    public function setMsg(string $m):void{
        $this->msg = $m ;
    }
    public function getMsg():string {
        return $this->msg ;
    }
}