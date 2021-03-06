<?php

/**
 * Zend Framework addition by skoch
 * 
 * @category   Skoch
 * @package    Skoch_Filter
 * @author     Stefan Koch <cct@stefan-koch.name>
 */
 
 
/**
 * Resizes a given file and saves the created file
 *
 * @category   Skoch
 * @package    Skoch_Filter
 */
abstract class Skoch_Filter_File_Resize_Adapter_Abstract
{
    abstract public function resize($width, $height, $keepRatio, $file, $target, $keepSmaller = true, $cropToFit = false);
    
    protected function _calculateWidth($oldWidth, $oldHeight, $width, $height)
    {
        // now we need the resize factor
        // use the bigger one of both and apply them on both
        $factor = max(($oldWidth/$width), ($oldHeight/$height));
        return array($oldWidth/$factor, $oldHeight/$factor);
    }

    public function _calculateSourceRectangle($oldWidth, $oldHeight, $destWidth, $destHeight)
    {
        $ratio = $destWidth / $destHeight;
        
        if ( ($destHeight / $oldHeight) < ($destWidth / $oldWidth) ) { // crop top/bottom
            $srcWidth = $oldWidth; $srcX = 0;
            $srcHeight = (int) ($oldWidth / $ratio);
            $srcY = (int) (($oldHeight - $srcHeight) / 2);
        } else { //crop left/right
            $srcHeight = $oldHeight;
            $srcY = 0;
            $srcWidth = (int) ($oldHeight * $ratio);
            $srcX = (int) (($oldWidth - $srcWidth) / 2);
        }
        
        return array($srcX, $srcY, $srcWidth, $srcHeight);
    }
}
