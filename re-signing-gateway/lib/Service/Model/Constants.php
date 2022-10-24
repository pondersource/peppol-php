<?php

namespace OCA\PeppolNext\Service\Model;

class Constants
{
	public const SEND_DIRECTION = 1;
	public const RECEIVE_DIRECTION = 2;

	public const INVOICE_MSG_TYPE = 1;
	public const MESSAGE_MSG_TYPE = 2;
	public const PURCHASE_MSG_TYPE = 3;

	public const AS4DIRECT_MEDIA_TYPE	= 1 ;
	public const PEPPOL_MEDIA_TYPE	= 2 ;
	public const PEPPOLNEXT_MEDIA_TYPE= 3 ;

	const PEPPOL_INDICATOR = '#PEPPOL#';
}
