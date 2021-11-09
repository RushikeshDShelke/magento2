## Automatic Related Product for Magento 2
Main features:
- Create rule for products and their related products.
- Use catalog chooser to define conditions.
- Override cross-sell, up-sell and related product blocks by
defined rules.
### To request support:

Feel free to contact us via email: support@x-mage2.com

### Demo version:

Frontend: http://demo2.x-mage2.com/product-advanced-widget

###1 - Installation

 * Download the extension
 * Unzip the file
 * Copy the content from the unzip folder to {Magento Root}

####2 -  Enable Extension

 * php -f bin/magento setup:upgrade
 * php bin/magento setup:static-content:deploy

####3 - Reindex Magento 2 

 * Using job: if you configured job and it runs properly,
 you just need to wait job reindex by schedule
 * Use shell command: bin/magento indexer:reindex

 Need to refresh cache after enable extension
