POST /register/ - регистрация и получении токена
    Параметры: 
    {
        name,
        email,
        password
    }


POST /login/ - логиование и получении токена
    Параметры: 
    {
        email,
        password
    }
    

POST /bid/create - создать заявку
    Параметры: 
    {
        message
    }
    
GET /bid/ - получить все заявки

POST /bid/{id пользователя}/ - Ответить на сообщеник
    Параметры: 
    {
        message
    }
    
GET /bid/date/ - получить заявку по дате

GET /bid/active/ - получить активные заявки

GET /bids/resolved/{id пользователя}/ - закрыть заявку
    Параметры: 
    {
        comment
    }


POST /logout/ - выход
