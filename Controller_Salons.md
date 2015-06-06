Controller_Salons
===============

Controller for salons page




* Class name: Controller_Salons
* Namespace: 
* Parent class: [Controller](Controller.md)







Methods
-------


### __construct

    mixed Controller_Salons::__construct()





* Visibility: **public**




### index

    mixed Controller_Salons::index()

Default action for list view of salons



* Visibility: **public**




### edit

    mixed Controller_Salons::edit()

Default action for edit or add view of salon



* Visibility: **public**




### save

    mixed Controller_Salons::save()

Method from save changes or insert new position to database
It should uses only from post
When finish import. Redirect to ::index



* Visibility: **public**




### import

    mixed Controller_Salons::import()

Import method from Excel file.

It should uses only from post and need have send $_FILES['excel'] file
When finish import. Redirect to ::index

* Visibility: **public**




### redirect

    mixed Controller::redirect($path)





* Visibility: **public**
* This method is defined by [Controller](Controller.md)


#### Arguments
* $path **mixed**



### setMsg

    mixed Controller::setMsg($desc, $type)





* Visibility: **public**
* This method is defined by [Controller](Controller.md)


#### Arguments
* $desc **mixed**
* $type **mixed**



### getMsg

    mixed Controller::getMsg()





* Visibility: **public**
* This method is defined by [Controller](Controller.md)




### http_digest_parse

    mixed Controller::http_digest_parse($txt)





* Visibility: **public**
* This method is defined by [Controller](Controller.md)


#### Arguments
* $txt **mixed**



### useAuth

    mixed Controller::useAuth()





* Visibility: **public**
* This method is defined by [Controller](Controller.md)



