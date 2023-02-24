<?php
namespace OCA\PeppolNext\Service\Helper;

/**
 * For vCard address (ADR) specification checkout https://www.evenx.com/vcard-3-0-format-specification
 */
class PostalAddress {

	public static function streetFromAddress(array $address): string {
		if (isset($address['line1']) && strlen($address['line1']) > 0) {
			if (isset($address['line2']) && strlen($address['line2']) > 0) {
				return $address['line1'].', '.$address['line2'];
			}
			else {
				return $address['line1'];
			}
		}
		else if (isset($address['line2']) && strlen($address['line2']) > 0) {
			return $address['line2'];
		}
		else {
			return '';
		}
	}

	public static function fromPeppolAddress(array $address): PostalAddress {
		$adr = new PostalAddress();

		if (isset($address['line1']) && strlen($address['line1']) > 0) {
			if (isset($address['line2']) && strlen($address['line2']) > 0) {
				$comma_position = strpos($address['line1'], ' , ');

				if ($comma_position > 0) {
					$adr->postOfficeAddress = substr($address['line1'], 0, $comma_position);
					$adr->extendedAddress = substr($address['line1'], $comma_position + 3);
				}
				else {
					$adr->postOfficeAddress = $address['line1'];
				}
				
				$adr->street = $address['line2'];
			}
			else {
				$adr->street = $address['line1'];
			}
		}
		else if (isset($address['line2']) && strlen($address['line2']) > 0) {
			$adr->street = $address['line2'];
		}

		$adr->locality = $address['city'];
		$adr->region = $address['state'];
		$adr->postalCode = $address['post_code'];
		$adr->country = $address['country']['name'];

		return $adr;
	}

	public string $postOfficeAddress = '';
	public string $extendedAddress = '';
	public string $street = '';
	public string $locality = ''; // city
	public string $region = '';
	public string $postalCode = '';
	public string $country = '';

	public function asVCardAddress(): array {
		return [
			$this->postOfficeAddress,
			$this->extendedAddress,
			$this->street,
			$this->locality,
			$this->region,
			$this->postalCode,
			$this->country
		];
		// return [$this->postOfficeAddress . ';' . 
		// 		$this->extendedAddress . ';' . 
		// 		$this->street . ';' .
		// 		$this->locality . ';' .
		// 		$this->region . ';' .
		// 		$this->postalCode . ';' .
		// 		$this->country];
	}

	public function asPeppolAddress(): array {
		$line1 = $this->extendedAddress;

		if (strlen($this->postOfficeAddress) > 0) {
			if (strlen($this->extendedAddress) > 0) {
				$line1 = $this->postOfficeAddress . ' , ' . $this->extendedAddress;
			}
			else {
				$line1 = $this->postOfficeAddress;
			}
		}

		return [
			'line1' => $line1,
			'line2' => $this->street,
			'city' => $this->locality,
			'post_code' => $this->postalCode,
			'state' => $this->region,
			'country' => UBLCountries::findCountry($this->country)
		];
	}

}
