# ACF getallobjects
## FOR DEVELOPERS Only!
get_field has cost in front end! it means when you perform this function it calls multiple time queries as you store data in your backend. in simple words if you had 1000 text box in your acf option back-end and you call acf get_field in front-end it will call mysql query 1000 times and if you want use acf and care about your performance you will need to use this plugin or other approciate approche.

Before use this plugin
========
![alt tag](https://raw.githubusercontent.com/devlifex/acf-getallobjects/master/assets/before.png)

After use this plugin
========
![alt tag](https://raw.githubusercontent.com/devlifex/acf-getallobjects/master/assets/after.png)

How is work?
========
After save acf in backend this plugin create record in Database(wp_options) with this pattern (acfAllObjects+post_id) as key
and put all your fields data as whole object in value. then you instead of
``` get_fields('foo', 'option')``` you can use ``` ACFAllObj::get('foo', 'option');```

How to Use?
========
1) Clone or Download in your plugins directory 
```bash
$ git clone https://github.com/devlifeX/acf-getallobjects.git
```
2) Activate plugin from wp-admin
3) Go to your acf post type (option or custom post type etc...) and save again (for create acfAllObjects record)
4) Go to your theme file and replace your current code with this structure
```php
 if (class_exists('ACFAllObj')) {   
        $foo = ACFAllObj::get('foo', 'option');
        $bar = ACFAllObj::get('bar', 'option');
    } else {
        $foo = get_field('foo', 'option');
        $bar = get_field('bar', 'option');
    }
```
