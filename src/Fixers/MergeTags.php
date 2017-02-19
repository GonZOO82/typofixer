<?php
declare(strict_types=1);

namespace Typofixer\Fixers;

use Typofixer\Fixer;
use Typofixer\Utils;
use DOMText;
use DOMNode;

/**
 * Merge consecutive tags. Example:
 * <strong>hello</strong> <strong>world</strong>
 * becomes to:
 * <strong>hello world</strong>
 */
class MergeTags implements FixerInterface
{
	private $tags = ['strong', 'em', 'b', 'i'];

	/**
	 * {@inheritdoc}
	 */
	public function __invoke(Fixer $fixer)
	{
		foreach ($fixer->nodes(XML_ELEMENT_NODE) as $node) {
			if (in_array($node->tagName, $this->tags) && $node->nextSibling) {
				if (self::isMergeable($node, $node->nextSibling)) {
					Utils::mergeNodes($node, $node->nextSibling);
					continue;
				}

				//If it's a space between
				if (
					$node->nextSibling->nodeType === XML_TEXT_NODE 
					&& trim($node->nextSibling->data) === '' 
					&& $node->nextSibling->nextSibling 
					&& self::isMergeable($node, $node->nextSibling->nextSibling)
				) {
					$node->parentNode->removeChild($node->nextSibling);
					$text = Utils::getFirstNodeText($node);
					$text->data .= ' ';
					Utils::mergeNodes($node, $node->nextSibling);
				}
			}
		}
	}

	private static function isMergeable(DOMNode $current, DOMNode $next) {
		return $next->nodeType === XML_ELEMENT_NODE && $next->tagName === $current->tagName;
	}
}