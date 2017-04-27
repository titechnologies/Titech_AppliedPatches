<?php
class Titech_AppliedPatches_Model_Installedpatches extends Mage_Core_Model_Abstract {
    /**
    * Store applied patches.
    * @var array
    */
    public $appliedPatches = array();

    /**
    * Store location reference to patch log file 'applied.patches.list'
    * @var string
    */
    private $patchFile;

    /**
    * Constructor
    * Load the applied patches array.
    * @return void
    */
    protected function _construct() {
        $this->patchFile = Mage::getBaseDir('etc') . DS . 'applied.patches.list';
        $this->_loadPatchFile();
    }

    /**
    * Read patch log file.
    * @return string
    */
    public function getPatches(){
        return implode(', ',$this->appliedPatches);
    }

    /**
    * Getting patches array with applied patches.
    * @return void
    */
    protected function _loadPatchFile() {
        $readwrite = new Varien_Io_File();
        if (!$readwrite->fileExists($this->patchFile)) {
            return;
        }

        $readwrite->open(array('path' => $readwrite->dirname($this->patchFile)));
        $readwrite->streamOpen($this->patchFile, 'r');

        while ($buffer = $readwrite->streamRead()) {
            if(stristr($buffer,'|')){
                list($date, $patchcode, $magentoVersion, $patchVersion) = array_map('trim', explode('|', $buffer));
                $this->appliedPatches[] = $patchcode . " " . $patchVersion;
            }
        }
    $readwrite->streamClose();
    }
}
