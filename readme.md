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

Please alter the port as to suit your environment.

```bash
docker run -p 80:80 -d -v /home/docker/bookstore/www:/var/www/bookstore -v bookstore
```

this API relies on Silex and has been pree installed.
Silex is a microframework for PHP, built on Symfony and Pimple and due to the very nature of this framework it very loosely coupled.

**Setup**

As a developer I have all .dev redirected to a local server so please not the Docker file and other provisioning assumes you have
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

1) Currently Books are converted into a stdClass which in turn can and will causes issues. 
2) On Validation or sanitation is connected one assumes a fully trusted and educated user base.  
this is because to render a book we need access to the protected properties, and to speed to creation
tests and code can call a Json serialised Object.
2) API document is flaky to see the least.
3) Unit test coverage is about 80% off the top of my head, however there is not direct test for the BookFilter Iterator,
and on test for the API end point itself, **Silex** is equipped with it's own tests so these should be added with the composer
autoload.
4) Finish documentation normally I would never commit code without documentation by the request and the time versus effort retarded
some commenting and doc blocks.

5) Application structure should have micro service independence's e.g Dockerfile.  
