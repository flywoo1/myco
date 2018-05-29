select * from persons p inner join owners o on p.idPerson = o.idPerson
inner join properties prop on prop.idproperty = o.idProperty
where prop.idCoproperty = 2;

select * from persons p inner join administrators a on p.idPerson = a.idPerson
where a.idCoproperty = 2;

insert into administrators (idCoproperty, idPerson, enabled) values (2,9,1)