# Saramin_PersonalProject
## 설치 필요
- npm
- php
- mysql
- composer
## DB설정
- project/.env파일
- DB_DATABASE -> mysql에 schema 설정
- DB_USERNAME -> mysql user name
- DB_PASSWORD -> mysql password
## 명령어 실행
> \> composer update -> composer통해 의존성 업데이트   
> \> npm install -> module 설치   
> \> php artisan migrate  -> DB 테이블을 자동으로 생성
## 서버 실행
> \> php artisan serve   
Laravel development server started: http://127.0.0.1:8000 -> 접속
## 회원가입
> 관리자페이지 접근법 : user 테이블의 admin을 1로 바꾸고 새로고침
