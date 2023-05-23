Delete Customer;
DBCC CHECKIDENT ('Customer',RESEED,0);
Insert into Customer(FirstName,LastName,Gender,DateOfBirth,Email,Phone,Address)
Values('Kim','Watene','Female','1988-10-17','kimwatene@gmail.com','0212476946','Wainuiomata');
Select * from Customer;