# M2S Vouchagram Extension for Magento 2


## Enable the extension

1.  after copy the M2s Extension into /app/code folder run follwing commands:
    ```
    php bin/magento setup:upgrade
    php bin/magento cache:flush
    php bin/magento setup:static-content:deploy
    ```
2.  Login to  Magento admin:
    ```
    Goto Stores -> Configuration -> Vouchagram -> Coupon Code -> Yes
    ```    