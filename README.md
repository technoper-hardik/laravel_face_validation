# Laravel Python
## Upload image verify person in image before saving

## Laravel setup

```commandline
composer install
```

```commandline
npm install
```

### Create .env file (copy from .env.example)

```commandline
php artisan generate:key
```

### Run NPM build to generate css and javascript files

```commandline
npm run build
```

### Create database in MySQL and update connection details in .env file

#### Let's migrate to have tables in database

```commandline
php artisan migrate --seed
```

## Python Setup

### Create Python Virtual Environment

```commandline
py -3 -m venv .venv
```

### Let's open that environment and install libraries

```commandline
.venv\Scripts\activate
```

```commandline
pip install dlib-19.24.99-cp312-cp312-win_amd64.whl
```

```commandline
pip install Flask opencv-python python-dotenv
```

## Run App

### Laravel Server

```commandline
php artisan serve
```

### Python Server (Open Virtual Env)

```commandline
.venv\Scripts\activate
```

### And Run Command

```commandline
python face_detection_api.py
```
