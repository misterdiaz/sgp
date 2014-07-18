SELECT v.proyecto_id, v.proyecto, p.fecha_inicio, p.fecha_culminacion, v.status_proyecto, SUM(v.avance) as avance
FROM v_actividades v
JOIN proyectos p ON v.proyecto_id=p.id
GROUP BY v.proyecto_id, v.proyecto, p.fecha_inicio, p.fecha_culminacion, v.status_proyecto
ORDER BY v.proyecto_id
--FALTA CALCULAR EL AVANCE DEL PROYECTO DE ACUERDO AL PESO DE LAS ACTIVIDADES