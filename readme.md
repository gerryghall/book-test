#`Gerry's Book Store`

Basic API for a factitious BookStore.

     * 
     * Please note there are area's within this code that purposely alters book data between an array, stdClass and Book Objects
     * this is to mimic Legacy code I have previouly worked with.
     *

**How To Install**

to install this Book Store, please clone the following git repository to your local computer and the run the following commands.

```bash
docker build -t bookstore .
```

Please alter the port to suit your environment.

```bash
docker run -p 80:80 -d -v /home/docker/bookstore/www:/var/www/bookstore -v bookstore
```

this API relies on Silex and has been pree installed.
Silex is a microframework for PHP, built on Symfony and Pimple and due to the very nature of this framework it very loosely coupled.

**Setup**

I have all **.dev** redirected to a local server so please not the Docker file and other provisioning assumes you have
 also redirected all **.dev** to your developement server also..

**How To Use**



**Create Books**
Below are too examples 


```shell
curl -X "POST" "http://bookstore.dev/api/books/create/" \
     -H "Content-Type: multipart/form-data; boundary=yNFyCwVVR5kTO6Ni5MRiN3gs2QfMTwyn" \
     -F "author=Josh Lockhart" \
     -F "title=Modern PHP: New Features and Good Practices" \
     -F "PHP=18.99" \
     -F "category=PHP" \
     -F "isbn=978-1491905012"
```  
  
```php
     $ch = curl_init();
     curl_setopt($ch, CURLOPT_URL, 'http://bookstore.dev/api/books/create/');
     curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
     curl_setopt($ch, CURLOPT_HTTPHEADER, [
       "Content-Type: multipart/form-data; boundary=2JesA4udYFISntiR3ukAnyfOY7qytfl1",
      ]
     );
     
     $body = [
       "author" => "Josh Lockhart",
       "title" => "Modern PHP: New Features and Good Practices",
       "PHP" => "18.99",
       "category" => "PHP",
       "isbn" => "978-1491905012",
       ];
     
     curl_setopt($ch, CURLOPT_POST, 1);
     curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
     $resp = curl_exec($ch);
     
     if(!$resp) {
       die('Error: "' . curl_error($ch) . '" - Code: ' . curl_errno($ch));
     } else {
       echo "Response HTTP Status Code : " . curl_getinfo($ch, CURLINFO_HTTP_CODE);
       echo "\nResponse HTTP Body : " . $resp;
     }
     
     curl_close($ch);
```
     

**Improvements**

1) Currently Books are being converted between books, stdClass's and arrays. 
2) No Validation or sanitation one assumes a fully trusted and educated user base.  
3) API document is flaky to say the least.
4) Unit test coverage is low, **Silex** is equipped with it's own tests so these should be added with the composer.
autoload.
4) Finish documentation normally I would never commit code without documentation, however the request, times, time versus effort, 
has retarded some commenting and doc blocks.

5) Application structure should have micro service independence's e.g Dockerfile.  
