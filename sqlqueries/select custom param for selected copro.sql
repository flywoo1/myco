select nbc.Label, nbc.order, nbe.value from coproperties c
inner join numericdatabycoproentities nbc 
on c.idCoproperty = nbc.idCoproperty
inner join numericdatabyentityid nbe
on nbe.idNumericDataByEntityId = nbc.idNumericDataByEntity
where nbe.idEntity=5
and c.idCoproperty=2
