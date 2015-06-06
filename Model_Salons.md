Model_Salons
===============

Model for salons list.




* Class name: Model_Salons
* Namespace: 
* Parent class: [Model_Sqlite](Model_Sqlite.md)





Properties
----------


### $_table

    protected mixed $_table





* Visibility: **protected**


### $_schemat

    protected mixed $_schemat





* Visibility: **protected**


### $source

    protected mixed $source





* Visibility: **protected**


### $_data

    protected mixed $_data





* Visibility: **protected**


Methods
-------


### getData

    mixed Model::getData()





* Visibility: **public**
* This method is **abstract**.
* This method is defined by [Model](Model.md)




### update

    boolean Model_Salons::update(object $obj)

Update method

Update method for salones table record
You must send object represation of data record

* Visibility: **public**


#### Arguments
* $obj **object**



### insert

    boolean Model_Salons::insert(object $obj)

Insert method

Insert new record to salons table
You must send object represation of data record

* Visibility: **public**


#### Arguments
* $obj **object**



### remove

    boolean Model_Salons::remove(object $obj)

Remove method

Remove item from salons table

* Visibility: **public**


#### Arguments
* $obj **object**



### importEXCEL

    mixed Model_Salons::importEXCEL(array $import)

Method for import data from Excel file



* Visibility: **public**


#### Arguments
* $import **array** - &lt;p&gt;insert global $_FILE where is $_FILE[&#039;excel&#039;]&lt;/p&gt;



### mapColumnIds

    array Model_Salons::mapColumnIds($worksheet)

Maps columns from Excel file for correct update



* Visibility: **private**


#### Arguments
* $worksheet **mixed**



### findShopColumn

    integer Model_Salons::findShopColumn(object $worksheet)

Return column id for shop id | name column



* Visibility: **private**


#### Arguments
* $worksheet **object**



### __construct

    mixed Model_Sqlite::__construct()





* Visibility: **public**
* This method is defined by [Model_Sqlite](Model_Sqlite.md)




### getConn

    mixed Model_Sqlite::getConn()





* Visibility: **public**
* This method is defined by [Model_Sqlite](Model_Sqlite.md)




### createTable

    mixed Model_Sqlite::createTable()





* Visibility: **private**
* This method is defined by [Model_Sqlite](Model_Sqlite.md)



