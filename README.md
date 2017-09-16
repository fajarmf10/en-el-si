En-El-Si
-------------

En-El-Si is a part of an annual event called Schematics.

- Login admin : root/panel/
  - Admin User : fajarmf:stupidmonkey
  - Operator : askan:askanyasin
- Login peserta : root/
  - 201701001:khezu

Kalo ada error, coba bikin folder **media/thumbs/** dan **media/source/**

Jangan lupa setting-setting tesnya dulu sebelum pake.

Mau dibenerin lagi. Untuk sementara segini dulu.

BUGS and PROBLEMS:
- [WIP] Desain
- [FIXED][thx to Hendry Wiranto @hendrywiranto] Timer kalo logout balik lagi ke waktu yang tersimpan setelah menjawab soal
	(solusi yg terpikirkan : tiap kali pindah soal, waktu_sisa disimpan, untuk yg logout belum tau/kepikiran)
- [FIXED] Timer ketika 2x klik home jadi double/triple/quadruple time cepetnya
	(solusi yg terpikirkan : daripada timer js diload di function(), countdown disimpan di session)
- [FIXED] Petunjuk harus terus-menerus dicentang dan dilewatin
	(solusi yg terpikirkan : ubah tabel, kasih flag di tabel yg nandain kalo user udah pernah centang petunjuk)
- [FIXED (?)] Waktu serentak (catatan: tabel nilai udah ada isinya duluan)
- [FIXED] Acak soal berantai (tiap 5 soal diacak)
- [FIXED] Mengosongkan jawaban (Tombol ragu-ragu diganti menjadi tombol kosongkan jawaban?), tanpa styling, radio button show
- [FIXED] Reset password peserta lewat panel admin -> Menjadi ganti password lewat panel sebagai admin
- Masukin manual di home page
- Some sh%ts yg belum bisa difixin karena sibuk cari jodoh, mantanmu gak kangen kon kok jar hehe


Copyright (C) 2017 Schematics ITS [schematics.its.ac.id][@sosispanggang, @znaznazna, @harkadious, and @hendrywiranto]
