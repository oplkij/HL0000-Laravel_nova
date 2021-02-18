# HL0000-Laravel_nova

* **Author**: Ken Chan (ken.chan@yucolab.com)

## Application Description
* A templete project of laravel nova
* A Backend CMS with RESTful API & base calendar function
* Using plugin (Full calendar, SwaggerApi)
* Base on Vue.js

## Development Environment
* **Windows 10**
* **Laravel nova 2.0**
* **PHP 7.2.19**
* **Vue 2.5.17**

## Main 3rd-party Frameworks/Libraries
* **[SwaggerApi 5.8](https://github.com/DarkaOnLine/L5-Swagger)**
* **[Fullcalendar 4.1.0](https://fullcalendar.io/docs/vue)**

## Development Environment Setup
* **[Laravel & Nova](https://github.com/yucolab/HL0000-Laravel_nova/wiki/Setup)**
* **[Swagger Api](https://github.com/yucolab/HL0000-Laravel_nova/wiki/Setup-Swagger-API)**
* **[FullCalendar](https://github.com/yucolab/HL0000-Laravel_nova/wiki/Setup-FullCalendar-v4.0)**
## [Nova Tools](https://nova.laravel.com/docs/2.0/customization/tools.html#overview)
### Defining Tools
```            
php artisan nova:tool {componentsName/packetName} (e.g "php artisan nova:tool LOBBY/GREETING-WALL")             
```
### Registering Tools
Open ```app/Providers/NovaServiceProvider.php```
```
use {componentsName/packageName/packageName}; (e.g "use LOBBY\GREETINGWALL\GREETINGWALL;")

/**
 * Get the cards that should be listed in the Nova sidebar.
 *
 * @return array
 */
public function tools()
{
    return [
        new GREETINGWALL,
    ];
}
```
### Coding Path
```
nova-components/GREETINGWALL/resources/js/components/Tool.vue
nova-components/GREETINGWALL/resources/views/navigation.blade.php
```
### Build
* cd to ```\YourProject\YourComponentsName\packageName```
* Run ```npm run watch / npm run build ```

## [Vue.js plugins Import](https://vuejs.org/)

### NPM
* cd to ```\YourProject\```
* ```npm install packageName```
* ```npm run dev / npm run build / npm run watch```

### Globally
* Open ```\YourProject\vendor\laravel\nova\resources\js\app.js``` 
```
import packageName from "packageName";
Vue.use(packageName);
```

### Local Import
```
import { packageName } from "packageName";
```
