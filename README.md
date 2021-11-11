## Full Stack Engineer Assignment

Requirement:

- Basic knowledge on Laravel Framework
- MySQL / MariaDB
- Basic knowledge on vuejs

## Getting Started
- Please fork this repo to your git repo (must be public repo)
- Please deploy the source code to your local server. You can refer to laravel [documentation](https://laravel.com/docs/8.x/installation#your-first-laravel-project) how to deploy the project locally.
- The project configure to have all the necessarily package (npm & composer), once you have your local server running please run:
- `$ npm install`
- `$ npm run dev` to compile all the front-end package
- `$ composer install`
- `php artisan migrate`
- `php artisan storage:link`
- Please register a user to begin with, e.g url: http://localhost/register, the localhost domain might be different if using different configuration for your localhost domain

## Assignment
1. go to http://localhost/moderator
2. You will see a screen as below:
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://prod-cdn.albaloo.com/offers/falcon_demo_intro.JPG?webp=1" width="400"></a></p>
3. This page is half prepare, where you need to complete it as your assignment.

#### Summary
In the moderator page, the page feature for user to upload and moderate the image with 3rd party API called Falcon. The falcon is still in beta version and not yet publish. The purpose of this page is for test & validation team to upload images and evaluate the result. More about Falcon can be found [here](https://hexoxys.com/falcon) 

#### Task #1
In the bottom section, you can upload any jpg file and try it, then you should notice (using web developer console) the request not success due to CORS issue.

1a - In order to fix the issue, we will use proxy request in order to avoid the CORS. Please provide your solution by modified the current API request in the frontend code and prepare a backend logic to request to the Falcon API and response back to frontend.
Below is the requirement and the details:

details:
- frontend script can be located in file `resources/js/moderator.js`
- backend script can be located in file `app/Http/Controllers/ModeratorController.php`
- the route for the api has been programmed  - [POST] http://localhost/api/moderator
- the method name bind in the root is `process()`, please provide your solution in that method in the `ModeratorController.php`
- the method should forward the frontend request to FALCON API, the after getting response from FALCON please response back to frontend with json content type
- e.g response from FALCON API:
- 
```json
{
  "Version": "1.0",
  "Message": "succeed",
  "Code": 0,
  "Min-Confidence": 0.7,
  "ModerationLabels": {
    "Explicit Nudity": {
      "Confidence": 1,
      "Labels": {
        "Bare Chested Male": 1
      }
    },
    "partial Nudity": {
      "Confidence": 0.94,
      "Labels": {
        "Male Swimwear or Underwear": 0.94
      }
    }
  }
}
```
1b - Once you got response from the FALCON API you'll notice the FALCON API return with bad json format (using single quote), please fix the format into correct JSON format

#### Task #2
2a. In the top section, please hook the moderation by image url work

details:
- Instead of upload a file from user machine, user also able to use any image url to moderate the image.
- When user click the `save` button, same api (which provided in your task 1a solution) will be request but with just different content in the body and the backend should distinguish the request either has binary file in the body or just image url path.
- The api should be flexible to handling binary file upload and image path url.
- The response should be similar content as task 1a.

#### Task #3
3a. Please modify the backend to store the image file locally in `app/storage/app/public`

details:
- The image should be store after moderation has been done.
- All stored image file name should have prefix `fim_` and followed by unique id to prevent duplication. e.g `fim_618a09d98655d.jpeg`

3b. Once image store, please store a record set in the `samples` table

details:
- The Model for `Sample` is already provided, please check in `app/Models/Sample.php`
- The field `path` should be fill with the image name e.g  `fim_618a09d98655d.jpeg`
- The field `moderation_data` should be fill with the FALCON API JSON response.

3c. Please store all `ModerationLabels` object in the JSON response to `sample_moderation_labels` table as below.

details:
for example: 
```json
{
  "Version": "1.0",
  "Message": "succeed",
  "Code": 0,
  "Min-Confidence": 0.7,
  "ModerationLabels": {
    "Explicit Nudity": {
      "Confidence": 1,
      "Labels": {
        "Bare Chested Male": 1
      }
    },
    "partial Nudity": {
      "Confidence": 0.94,
      "Labels": {
        "Male Swimwear or Underwear": 0.94
      }
    }
  }
}
```
Please store 2 set of records

| id |  names          |  confidence  | sample_id  |
|----|-----------------|--------------|------------|
| 1  | explicit-nudity | 1            | 1          |
| 2  | partial-nudity  | 0.94         | 1          |

 - note that `sample_id` field is the foreign key from the `sample` table references on `id` field
 - names field should be in small letter and space will be converted to `-` symbol
 - confidence is the decimal number of each `ModerationLabels` child object

#### Task 4
4a. Please add a screen to display the text of JSON: 
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://prod-cdn.albaloo.com/offers/falcon_demo_complete_ui.JPG?webp=1" width="400"></a></p>

details:
- feel free to use any style you like, the image just to show an example how it should look like.

4b. Please make the drop & drag at the bottom section works.

details:
- Currently user won't able to drag & drop the file in the bottom section, please make the box so user can drag & drop their local file to the box

### Finish Step
Once you've done, please email us your fork repository.
