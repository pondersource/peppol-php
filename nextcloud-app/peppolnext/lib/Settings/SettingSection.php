<?php

namespace OCA\PeppolNext\Settings;

use OCP\Settings\IIconSection;

class SettingSection implements IIconSection
{

    /**
     * @inheritDoc
     */
    public function getIcon()
    {
        // TODO: Implement getIcon() method.
    }

    /**
     * @inheritDoc
     */
    public function getID()
    {
		return "peppolnext";
    }

    /**
     * @inheritDoc
     */
    public function getName()
    {
		return "Peppol Next Settings";
    }

    /**
     * @inheritDoc
     */
    public function getPriority()
    {
        return 90;
    }
}
