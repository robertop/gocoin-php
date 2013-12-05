gocoin-PHP
===========

A PHP client library for the GoCoin API.


## Usage

```php
 $client = new Client( array(        
        'client_id' => "",
        'client_secret' => "",
        'scope' => "",
	....
    ));
// if need to get access_token
 $client->initToken();
 $b_auth = $client->authorize_api();

 $user = $client->api->user;
 $user_info = $user->self();
 ...
```

## Methods

### $Users

##### $user->self()
##### $user->_list()
##### $user->create(params)
##### $user->delete(id)
##### $user->get(id)
##### $user->update(params)
##### $user->update_password(params)
##### $user->request_password_reset(params)
##### $user->new_confirmation_email(params)
##### $user->reset_password_with_token(params)


### Merchants

##### $merchant->_list()
##### $merchant->create(params)
##### $merchant->delete(id)
##### $merchant->get(id)
##### $merchant->update(params)


### Apps

##### $apps->create(params)
##### $apps->create_code(params)
##### $apps->delete(id, )
##### $apps->delete_authorized(id)
##### $apps->get(id)
##### $apps->_list()
##### $apps->list_authorized()
##### $apps->update(params)
##### $apps->new_secret(id)

### Accounts

##### $apps->list(id)


### Invoices

##### $invoices->create(params)
##### $invoices->get(id)
##### $invoices->search(params)


### License

Copyright 2013 GoCoin Pte. Ltd.

Licensed under the Apache License, Version 2.0 (the "License");
you may not use this file except in compliance with the License.
You may obtain a copy of the License at

   http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing, software
distributed under the License is distributed on an "AS IS" BASIS,
WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
See the License for the specific language governing permissions and
limitations under the License.
