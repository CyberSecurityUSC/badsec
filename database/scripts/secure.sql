delete from user where user not in ('someguy','randomthing','thenorris','board', 'wp');
flush privileges;