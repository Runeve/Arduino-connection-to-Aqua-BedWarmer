# Arduino C# connection program to Smart Bed
: C # Programm that receive Data via Arduino with Two Pressure Sensors Attached to Smart Bed.

DB uses Xampp to access and manage the mysql database with phpmyadmin.

> 스마트 온수매트에 연결된 두 개의 압력 센서에서 Arduino를 통해 데이터를 수신하는 C # 프로그랩입니다.
> DB는 Xampp를 사용하여 phpmyadmin으로 mysql 데이터 베이스를 접근해 관리하고 호출합니다.
> C#프로그램에서 웹서버를 호출하면 웹서버에서 디비로 쿼리를 주는 형식입니다.

# 데이터 베이스 setting 방법

1. XAMPP를 다운받습니다.
   [XAMPP Download[(https://www.apachefriends.org/index.html)

2. XAMPP Control Panel에서 Port를 수정합니다
   > Apache -> Config -> Apache(http.conf) 클릭해 Listen 다음 숫자를 8080으로 수정합니다.

3. Apache 와 MySQL을 자동 시작하게 설정합니다.
   > 패널의 우측 상단의 Config에서 Autostart of modules에 Apache와 MySQL을 체크합니다.

4. htdocs파일을 복사합니다.
   > 다운받은 htdocs파일을 xampp 파일 안의 htdocs파일에 덮어쓰기를 합니다.

5. 데이터 베이스를 구축합니다.
   >localhost:8080/phpadmin 으로 접속해 다운받은 sql를 내려 받기 해서 데이터 베이스를 구축합니다.

# 프로그램 실행 방법

1. exe 파일을 실행합니다.

2. 서버 IP를 입력합니다

3. 연결한 smart bed의 포트를 입력합니다
   > 제어판 -> 장치관리자에서 포트 부분을 확인합니다

4. sensor id와 데이터 송신 구간을 설정합니다.

5. 연결 버튼을 누른 후 연결이 완료되면 데이터 수신 버튼을 누릅니다.
