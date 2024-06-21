# Branches

How to start?
```
rm -rf vendor
rm composer.lock
php composer.phar install
php test.php
```


## Before changes
### branch: master

```
"19.366332292557 ms" // test.php:38
"20.48 KB" // test.php:39
```

### After changes
### branch: reflection-optimization

```
"15.390226840973 ms" // test.php:38
"10.24 KB" // test.php:39
```
