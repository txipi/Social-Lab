<?php


/**
 * Skeleton subclass for representing a row from the 'automsg' table.
 *
 * 
 *
 * This class was autogenerated by Propel 1.4.2 on:
 *
 * Sat Oct 13 17:53:12 2012
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class Automsg extends BaseAutomsg {

        public function __toString() {
                return substr($this->getText(), 0, 20);

        }

} // Automsg
