package com.thomsonreuters.controller;

import java.util.List;

import com.thomsonreuters.datamodel.AttributeDef;
import com.thomsonreuters.datamodel.EntityAttributeDef;
import com.thomsonreuters.datamodel.EntityDef;
import com.thomsonreuters.datamodel.RelationDef;

public interface Controller {
	
	public AttributeDef getAttribute(String userId, String attrId);
	public List<AttributeDef> getAttributes(String userId);
	public long addAttribute(String userId, String attrContent);
	public long updateAttribute(String userId, String attrContent);
	public long enableAttribute(String userId, String attrId);
	public long disableAttribute(String userId, String attrId);
	public long deleteAttribute(String userId, String attrId);

	public EntityDef getEntity(String userId, String entityId);
	public List<EntityDef> getEntities(String userId);
	public long addEntity(String userId, String entityContent);
	public long updateEntity(String userId, String entityContent);
	public long enableEntity(String userId, String entityId);
	public long disableEntity(String userId, String entityId);
	public long deleteEntity(String userId, String entityId);

	public EntityAttributeDef getEntityAttribute(String userId, String entityAttrId);
	public List<EntityAttributeDef> getEntitiesAttributes(String userId);
	public long addEntityAttribute(String userId, String entityAttrContent);
	public long updateEntityAttribute(String userId, String entityAttrContent);
	public long enableEntityAttribute(String userId, String entityAttrId);
	public long disableEntityAttribute(String userId, String entityAttrId);
	public long deleteEntityAttribute(String userId, String entityAttrId);

	
	

	public RelationDef getRelation(String userId, String relationId);
	public List<RelationDef> getRelations(String userId);
	public long addRelation(String userId, String relationContent);
	public long updateRelation(String userId, String relationContent);
	public long enableRelation(String userId, String relationId);
	public long disableRelation(String userId, String relationId);
	public long deleteRelation(String userId, String relationId);

/*
	public DiseaseEntity getBasic(String id, String serviceUserId) throws AppException, LicenseException, SQLException;
	public DiseaseEntity getSummary(String id, String serviceUserId) throws AppException, LicenseException, SQLException;
	public DiseaseEntity get(String id, String serviceUserId) throws AppException, LicenseException, SQLException;
	
	public List<DiseaseEntity> searchBasic(String searchTerm, String maxResults, String serviceUserId) throws AppException, LicenseException, SQLException;
	public List<DiseaseEntity> searchSummary(String searchTerm, String maxResults, String serviceUserId) throws AppException, LicenseException, SQLException;
	public List<DiseaseEntity> search(String searchTerm, String maxResults, String serviceUserId) throws AppException, LicenseException, SQLException;

	public List<DiseaseEntity> advancedSearchBasic(String searchTerms, String maxResults, String serviceUserId) throws AppException, IOException, LicenseException, SQLException;
	public List<DiseaseEntity> advancedSearchSummary(String searchTerms, String maxResults, String serviceUserId) throws AppException, IOException, LicenseException, SQLException;
	public List<DiseaseEntity> advancedSearch(String searchTerms, String maxResults, String serviceUserId) throws AppException, IOException, LicenseException, SQLException;
	
	public List<DiseaseEntity> list(String maxResults, String serviceUserId) throws AppException, LicenseException, SQLException;
	
	public long insert(String content, String serviceUserId) throws AppErrorException, AppException, IOException, LicenseException, SQLException;
	public long update(String content, String serviceUserId) throws AppErrorException, AppException, IOException, LicenseException, SQLException;
	public void delete(String id, String serviceUserId) throws AppErrorException, AppException, LicenseException, SQLException;
	
	public List<MedDRA> getMedDRA(String serviceUserId) throws AppException, LicenseException, SQLException;
	public List<MedDRA> getFullMedDRA(String serviceUserId) throws AppException, LicenseException, SQLException;
*/
}
