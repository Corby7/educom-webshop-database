```mermaid
%%{`  More info on mermaid notation see: https://mermaid.js.org/syntax/entityRelationshipDiagram.html.  `}%%

---
title: Order example
---
erDiagram
    users ||--o{ orders : Places
    users {
        int    id        PK
        string name
        string email     UK
        string password
    }    
    orders ||--|{ orderlines : Contains
    orders {
        int    id                PK
        int    user_id           FK
        string date  
    } 

    orderlines }|--|| products : Contains
    orderlines {
        int    id                PK
        int    order_id           FK
        int    product_id        FK
        float  amount   
    } 

    products {
        int    id                PK
        string name
        string description
        float price
        string filename_image     
    }
```
