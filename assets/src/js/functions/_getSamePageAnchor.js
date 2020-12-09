/**
 * Checks if the href belongs to the same page and returns the anchor if so.
 *
 * @param  {String} href
 * @returns {Boolean|String}
 */
function getSamePageAnchor(href) {
    var link = document.createElement('a');
    link.href = href;

    /**
     * For IE compatibility
     * @see https://stackoverflow.com/a/24437713/1776901
     */
    var linkCanonical = link.cloneNode(false);

    if (
        linkCanonical.protocol !== window.location.protocol ||
        linkCanonical.host !== window.location.host ||
        linkCanonical.pathname !== window.location.pathname ||
        linkCanonical.search !== window.location.search
    ) {
        return false;
    }

    return link.hash;
}