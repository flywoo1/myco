select 'time' as type, tbct.enabled, tbe.idTimeDataByEntityId as key_value, tbct.idTimeDataByCoproEntity as key_conf,  tbct.label, tbct.fieldorder, tbe.value from timeDataByCoproEntities tbct
inner join TimeDataByEntityId tbe on tbct.idTimeDataByCoproEntity = tbe.idTimeDataByCoproEntity
where tbct.idCoproperty='2' and tbct.idEntity='5' and tbe.id='2'
Union 
select 'string', sbct.enabled, sbe.idStringDataByEntityId, sbct.idStringDataByCoproEntity , sbct.label, sbct.fieldorder, sbe.value from stringdatabycoproentities sbct
inner join StringDataByEntityId sbe on sbct.idStringDataByCoproEntity = sbe.idStringDataByCoproEntity
where sbct.idCoproperty='2' and sbct.idEntity='5' and sbe.id='2'
Union
select 'file', fbct.enabled, fbe.idFileByEntityId, fbct.idFileByCoproEntity, fbct.label, fbct.fieldorder, fbe.value from filebycoproentities fbct
inner join fileByEntityId fbe on fbct.idFileByCoproEntity = fbe.idFileByCoproEntity
where fbct.idCoproperty='2' and fbct.idEntity='5' and fbe.id='2'
Union
select 'numeric', nbct.enabled, nbe.idnumericdataByEntityId, nbct.idNumericDataByCoproEntity, nbct.label, nbct.fieldorder, nbe.value from numericdatabycoproentities nbct
inner join numericdataByEntityId nbe on nbct.idnumericdataByCoproEntity = nbe.idnumericdataByCoproEntity
where nbct.idCoproperty='2' and nbct.idEntity='5' and nbe.id='2'
order by fieldorder
