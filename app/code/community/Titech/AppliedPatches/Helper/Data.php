<?php
class Titech_AppliedPatches_Helper_Data extends Mage_Core_Helper_Abstract{
    public function getPatches(){
        return Mage::getModel('appliedpatches/installedpatches')->getPatches();
    }
}
