Delete from ServiceCategory;

DBCC CHECKIDENT ('ServiceCategory',RESEED,0);

Insert into ServiceCategory(Name)
Values('Brow, Lips, Eyeliner');

Insert into ServiceCategory(Name)
Values('Waxing and Threading');

Insert into ServiceCategory(Name)
Values('Ear Piercing');

Insert into ServiceCategory(Name)
Values('IPL Hair Removal');

Select * from ServiceCategory;