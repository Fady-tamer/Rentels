<img src="https://github.com/Fady-tamer/Rentels/blob/main/img/project%20logo.png?raw=true">

## About

Project about Rentals/Real Estate Marketplace

## Objectives

```
  • make accounts of seller and buyer
  • how seller to add products post
  • make Live Search/Filter
```

## Pages

```
  • Login/sign up page
  • catalog (main) page
```

## Database

```
  • Account
      |
      |___( seller )
      |        |
      |        |___( fullName) => varchar
      |        |___( email ) => varchar
      |        |___( phone ) => varchar
      |        |___( password ) => varchar
      |
      |___( buyer )
              |
              |___( fullName) => varchar
              |___( email ) => varchar
              |___( password ) => varchar

  • products
      |
      |_____( type ) => varchar
      |_____( price ) => int
      |_____( address ) => varchar
      |          |
      |          |___( streat )
      |          |___( area )
      |          |___( Governorate )
      |
      |_____( area ) => int
      |_____( bedroom ) => int
      |_____( bathroom ) => int
```
