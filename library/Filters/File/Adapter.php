<?php

/**
 * Zend Framework addition by skoch
 *
 * @category   Skoch
 * @package    Skoch_Filter
 * @license    http://opensource.org/licenses/gpl-license.php GNU Public License
 * @author     Stefan Koch <cct@stefan-koch.name>
 */


/**
 * Created by JetBrains PhpStorm.
 * User: User
 * Date: 20/11/12
 */
abstract class Filters_File_Adapter
{

    abstract public function resize($width, $height, $keepRatio, $file, $target, $keepSmaller = true);

    /**
     * @param $oldWidth
     * @param $oldHeight
     * @param $width, new width, if this is 0 or less it will calculate resize based on ratio of $oldHeight/$height
     * @param $height, new height, if this is 0 or less it will calculate resize based on ratio of $oldWidth/$width
     * @return array
     */
    protected function _calculateWidth($oldWidth, $oldHeight, $width, $height)
    {
        // now we need the resize factor
        $factor = 1;
        // resize according to height
        if($width < 1){
            $factor = $oldHeight/$height;
        }
        // resize according to width
        if($height < 1){
            $factor = $oldWidth / $width;
        }
        // use the bigger one of both and apply them on both
        if($height > 0 && $width > 0){
            $factor = max(($oldWidth / $width), ($oldHeight / $height));
        }
        return array($oldWidth / $factor, $oldHeight / $factor);
    }
}
