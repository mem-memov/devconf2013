<?php
interface Doctor_Service_Interface_TreeMaker {
    
    public function toArray();
    public function toFlatArray();
    public function findNodeById($id = null);
    public function removeNode(Doctor_Service_Interface_TreeMaker $node);
    public function append(Doctor_Service_Interface_TreeMaker  $targetNode, array $nodes);
    public function insertBefore(Doctor_Service_Interface_TreeMaker  $targetNode, array $nodes);
    public function insertAfter(Doctor_Service_Interface_TreeMaker  $targetNode, array $nodes);
    
}