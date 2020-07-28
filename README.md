# studga-wohlnet-ru
Система расписаний МГТУ ГА

# История проекта
Это полный исходный код системы расписаний МГТУ ГА, созданной мною в 2013м году
и пассивно поддерживаемой мною в течении многих лет. Проект я создал ещё будучи
студентом для того, чтобы устранить массу неудобств, возникавших при пользовании
официальными источниками расписания. Идея появилась у меня ещё в 2011м году,
когда я экспериментировал с попытками создать сайт-портал для нашего потока,
одной из страниц которого было расписание нашей группы, которое исключало ячейки
уже прошедших дней, добавляя расписанию наглядность. Чуть позже я решил сделать
нечто более серьёзное, а заодно сделать это полностью автоматичеким. В итоге, к
грядушей конференции, проводимой у меня в университете, я представил
экспериментальный прототип будущей системы расписаний, введя вручную расписания
моего потока в качестве тестовых данных. Несколькими месяцами позже я смог
допилить систему, введя её в полную боевую готовность. Изначально система
работала на домене sd.mstuca.su, используя домен, отданный в пользование мне
моим другом со старших курсов. Позже, домен истёк, а друг его так и не продлил.
В итоге я создал новый домен, назвав его studga.ru, а расписание повесив на
поддомен sd. У меня были планы создать полноценный студенческий портал с
различными разделами там, а не только с расписанием. Однако, желания на всё это
так и не хватило. К 2014му году я окончательно завязал с веб-разработкой и стал
двигаться в сторону C++, начав мой большой и основной проект Moondust
(он же PGE Project).

С тех пор, как я закончил Университет Гражданской Авиации в 2015м году, я
перестал уделять этому проекту достаточного внимания для дальнейшего развития.
В итоге, я ограничивался тем, что исправлял в нём видные ошибки и глюки. А также
отвечал на письма, которые мне периодически приходили от разных студентов, 
сообщавших об ошибках, или задающих различные вопросы.

Последний раз, когда я вносил в систему значительное обновление, это февраль
2018го года, когда я полностью заменил скрипт-загрузчик, который периодически
обращался к официальному сайту университета, запрашивая у него обновлённые
расписания. Изначальный скрипт был крайне неповортлиым и кривым, и мне уже
надоело его постоянно чинить. Результатом моих трудов стал отдельный
модуль-загрузчик, опубликованный в этом репозитории:
https://github.com/Wohlstand/studga-xls2db

Чуть позже, я решил постепенно избавиться от домена studga.ru, перенеся систему
расписаний на поддомен моего основного сервера: studga.wohlnet.ru. 

Чтобы дать другим людям возможность помочь хоть как-нибудь с проектом, я ещё 
давно думал открыть все его исходники. Я хотел сделать это и раньше, однако
боялся на счёт возможных уязвимостей и страшной кривизны кода, которую я
намесил будучи студентом без опыта.

С Университетом Гражданской Авиации меня уже давно ничего не связывает, и я бы
мог похоронить проект ещё в 2015м году, но не стал этого делать. Параллельно с
моим сайтом, существовал ещё один сайт расписаний, который управлялся одиним моим
знакомым со старших курсов. Однако, когда он закончил университет, его сайт был
немедленно захоронен, одномоментно сделав мой проект монополистом. Я не стал
хоронить проект, потому что осознаю, что им пользуется половина университета, и
даже больше (что видно по Яндекс-метрике), и хоронить такой проект было бы
знаком подлости.

Было бы очень здорово, если бы мой проект смогли бы физически разместить на
одном из действующих серверов университета, чтобы я смог наконец оставить этот
проект с чистой душой.

29 июля 2020 года проект прекратил свою работу, непрерывно проработав целых 7 лет.

# Связь с разработчиком
По любым вопросам со мной можно связаться по электронной почте: admin кошка wohlnet.ru

