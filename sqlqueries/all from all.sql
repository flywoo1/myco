select * from entities;

select * from persons;

select * from properties;
select * from coproperties;
select  * from stringdatabycoproentities;

select * from owners;


insert into properties (identification, idCoproperty, suscriptionDate, enabled) 
values
('Manzana 28 - Lote 62', 2, Now(),1);

insert into owners (idPerson, idProperty, startDate, enabled, living)
values
(1,1, Now(),1,1);

insert into administrators (idPerson, idCoproperty, enabled)
values
(1,2,1);

insert into stringdatabycoproentities (idCoproperty, idEntity, Label, enabled, fieldorder) 
values (2,1,'Notes', 1,1);

insert into stringdatabyentityid (idstringdatabycoproentity, id, value, enabled) 
values (2, 1, 'Pas l''emmerder', 1)