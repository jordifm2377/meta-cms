package com.thomsonreuters.model;

import com.google.inject.Inject;
import com.google.inject.Singleton;

import com.thomsonreuters.cms.db.DatabaseExecutor;
import com.thomsonreuters.cms.db.ResultObject;
import com.thomsonreuters.cms.db.RowObject;
import com.thomsonreuters.cms.db.UtilsDatabase;
import com.thomsonreuters.cms.exception.AppErrorException;
import com.thomsonreuters.cms.exception.AppException;
import com.thomsonreuters.cms.exception.LicenseException;
import com.thomsonreuters.cms.synchronization.Synchronization;
import com.thomsonreuters.cms.utils.Utils;
import com.thomsonreuters.cms.utils.UtilsData;
import com.thomsonreuters.query.Query;

import java.sql.SQLException;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.HashSet;
import java.util.List;
import java.util.Set;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

@Singleton
public class CatalogModelImpl {
	
	private static final Logger logger = LoggerFactory.getLogger("CatalogModelImpl");
	
	private final AttributeModel attributeModel;
	private final EntityModel entityModel;
	private final EntityAttributeModel entiyAttributeModel;
	
	@Inject
	public CatalogModelImpl(AttributeModel attributeModel, EntityModel entityModel, EntityAttributeModel entiyAttributeModel) {
		this.attributeModel = attributeModel;
		this.entityModel = entityModel;
		this.entiyAttributeModel = entiyAttributeModel;
	}
/*	
	private DiseaseMedDRAModel diseaseMedDRAModel;
	private DiseaseSynonymModel diseaseSynonymModel;
	private DiseaseTherapeuticActivityModel diseaseTherapeuticActivityModel;
	
	private static final String tableName = "DISEASE";
	private static final String sequenceName = "disease_seq";
	private static final String tableNameSelf = "DISEASE_SELF";
	private static final String sequenceNameSelf = "disease_self_seq";
	
	@Inject
	public CatalogModelImpl(DiseaseSynonymModel diseaseSynonymModel, DiseaseMedDRAModel diseaseMedDRAModel, DiseaseTherapeuticActivityModel diseaseTherapeuticActivityModel) {
		
		this.diseaseSynonymModel = diseaseSynonymModel;
		this.diseaseMedDRAModel = diseaseMedDRAModel;
		this.diseaseTherapeuticActivityModel = diseaseTherapeuticActivityModel;
	}
	
	private DiseaseEntity getEntityBasic(RowObject rowObject) {
		
		DiseaseEntity entity = new DiseaseEntity();
		
		entity.setId( Long.parseLong( UtilsData.getValue(rowObject.getRowValue(), "DISEASE_ID") ) );
		entity.setName( UtilsData.getValue(rowObject.getRowValue(), "NAME") );
		
		return entity;
	}
	
	private DiseaseEntity getEntitySummary(RowObject rowObject, boolean includeRelatedEntities, DatabaseExecutor databaseExecutor) throws SQLException {
		
		DiseaseEntity entity = getEntityBasic(rowObject);
		
		if (includeRelatedEntities) {
			entity.setDiseaseMedDRAs( diseaseMedDRAModel.getSummaryAll( entity.getId(), databaseExecutor) );
			entity.setDiseaseSynonyms( diseaseSynonymModel.getSummaryAll( entity.getId(), databaseExecutor) );
			entity.setDiseaseTherapeuticActivities( diseaseTherapeuticActivityModel.getSummaryAll( entity.getId(), databaseExecutor) );
		}
		
		return entity;
	}
	
	private DiseaseEntity getEntity(RowObject rowObject, DatabaseExecutor databaseExecutor) throws SQLException {
		
		DiseaseEntity entity = getEntitySummary(rowObject, false, databaseExecutor);
		
		entity.setComments( UtilsData.getValue(rowObject.getRowValue(), "COMMENTS") );
		entity.setCreatedByUserId( Long.parseLong( UtilsData.getValue(rowObject.getRowValue(), "CREATED_BY_USER_ID") ) );
		entity.setCreatedByUser( UtilsData.getValue(rowObject.getRowValue(), "CREATED_BY_USER") );
		entity.setCreatedOn( UtilsData.getValue(rowObject.getRowValue(), "CREATED_ON") );
		entity.setUpdatedByUserId( Long.parseLong( UtilsData.getValue(rowObject.getRowValue(), "UPDATED_BY_USER_ID") ) );
		entity.setUpdatedByUser( UtilsData.getValue(rowObject.getRowValue(), "UPDATED_BY_USER") );
		entity.setUpdatedOn( UtilsData.getValue(rowObject.getRowValue(), "UPDATED_ON") );
		
		entity.setDiseaseMedDRAs( diseaseMedDRAModel.getAll( entity.getId(), databaseExecutor) );
		entity.setDiseaseSynonyms( diseaseSynonymModel.getAll( entity.getId(), databaseExecutor) );
		entity.setDiseaseTherapeuticActivities( diseaseTherapeuticActivityModel.getAll( entity.getId(), databaseExecutor) );
		
		return entity;
	}
	
	@Override
	public DiseaseEntity getBasic(long id, DatabaseExecutor databaseExecutor) throws AppException, LicenseException, SQLException {
		
		String query = Query.getBasic_QUERY;
		
		Object[] parameters = new Object[]{id};
		
		ResultObject resultObject = databaseExecutor.retrieveQuery(query, parameters);
		
		if (resultObject.getRows().isEmpty()) {
			throw new AppException(AppException.entityDoesNotExist);
		}
		
		return getEntityBasic(resultObject.getRows().get(0));
	}
	
	@Override
	public DiseaseEntity getSummary(long id, DatabaseExecutor databaseExecutor) throws AppException, LicenseException, SQLException {
		
		String query = Query.getSummary_QUERY;
		
		Object[] parameters = new Object[]{id};
		
		ResultObject resultObject = databaseExecutor.retrieveQuery(query, parameters);
		
		if (resultObject.getRows().isEmpty()) {
			throw new AppException(AppException.entityDoesNotExist);
		}
		
		return getEntitySummary(resultObject.getRows().get(0), true, databaseExecutor);
	}
	
	@Override
	public DiseaseEntity get(long id, DatabaseExecutor databaseExecutor) throws AppException, LicenseException, SQLException {
		
		String query = Query.get_QUERY;
		
		query = query.replace("{userQuery}", UtilsData.user_QUERY);
		
		Object[] parameters = new Object[]{id};
		
		ResultObject resultObject = databaseExecutor.retrieveQuery(query, parameters);
		
		if (resultObject.getRows().isEmpty()) {
			throw new AppException(AppException.entityDoesNotExist);
		}
		
		return getEntity(resultObject.getRows().get(0), databaseExecutor);
	}
	
	@Override
	public List<Long> search(String searchTerm, long userId, DatabaseExecutor databaseExecutor) throws AppException, LicenseException, SQLException {
		
		Constraint.checkConstraintsForSearching(searchTerm, userId);
		
		searchTerm = ("%" + searchTerm + "%").toUpperCase();
		
		String query = Query.search_QUERY;
		
		Object[] parameters = new Object[]{searchTerm, searchTerm};
		
		ResultObject resultObject = databaseExecutor.retrieveQuery(query, parameters);
		
		List<Long> list = new ArrayList<>();
		
		for (RowObject rowObject : resultObject.getRows()) {
			
			list.add( Long.parseLong( UtilsData.getValue(rowObject.getRowValue(), "DISEASE_ID") ) );
		}
		
		logger.debug("Retrieved {} entities for term {}", list.size(), searchTerm.toLowerCase());
		
		return list;
	}
	
	@Override
	public List<Long> search(SearchEntity searchTerms, long userId, DatabaseExecutor databaseExecutor) throws AppException, LicenseException, SQLException {
		
		Constraint.checkConstraintsForAdvancedSearch(searchTerms, userId);
		
		searchTerms.buildWhereClause();
		
		String query = Query.advancedSearch_QUERY + searchTerms.getWhereClause();
		
		Object[] parameters = searchTerms.getParameters();
		
		ResultObject resultObject = databaseExecutor.retrieveQuery(query, parameters);
		
		List<Long> list = new ArrayList<>();
		
		for (RowObject rowObject : resultObject.getRows()) {
			
			list.add( Long.parseLong( UtilsData.getValue(rowObject.getRowValue(), "DISEASE_ID") ) );
		}
		
		logger.debug("Retrieved {} entities that match criteria", list.size());
		
		return list;
	}
	
	@Override // TODO is this method needed?
	public List<Long> getList(long userId, DatabaseExecutor databaseExecutor) throws LicenseException, SQLException {
		
		Constraint.checkConstraintsForListing(userId);
		
		List<Long> list = new ArrayList<>();
		
		String query = Query.list_QUERY;
		
		Object[] parameters = new Object[]{};
		
		ResultObject resultObject = databaseExecutor.retrieveQuery(query, parameters);
		
		for (RowObject rowObject : resultObject.getRows()) {
			
			list.add( Long.parseLong( UtilsData.getValue(rowObject.getRowValue(), "DISEASE_ID") ) );
		}
		
		logger.debug("Retrieved {} entities", list.size());
		
		return list;
	}
	
	private void insertEntity(DiseaseEntity entity, DatabaseExecutor databaseExecutor) throws AppErrorException, AppException, SQLException {
		
		entity.setId( databaseExecutor.retrieveSequenceValue(sequenceName) );
		
		String query = Query.insert_QUERY;
		
		query = query.replace("{timestamp}", UtilsDatabase.SYSDATE);
		
		Object[] parameters = new Object[]{entity.getId(), entity.getName(), entity.getComments(),
				entity.getCreatedByUserId(), entity.getUpdatedByUserId()};
		
		boolean success = databaseExecutor.persistQuery(query, parameters);
		
		if (!success) {
			throw new AppErrorException(AppErrorException.add);
		}
		
		if (!Synchronization.trackAdd(tableName, entity.getId(), databaseExecutor)) {
			throw new AppErrorException(AppErrorException.synchronization);
		}
		
		logger.debug("Adding Entity Id {}", entity.getId());
	}
	
	private void insertParent(DiseaseEntity entity, DatabaseExecutor databaseExecutor) throws AppErrorException, SQLException {
		
		Long id = databaseExecutor.retrieveSequenceValue(sequenceNameSelf);
		
		String query = Query.insertParent_QUERY;
		
		query = query.replace("{timestamp}", UtilsDatabase.SYSDATE);
		
		Object[] parameters = new Object[]{id, entity.getParentId(), entity.getId(), entity.getCreatedByUserId(), entity.getUpdatedByUserId()};
		
		boolean success = databaseExecutor.persistQuery(query, parameters);
		
		if (!success) {
			throw new AppErrorException(AppErrorException.add);
		}
		
		if (!Synchronization.trackAdd(tableNameSelf, id, databaseExecutor)) {
			throw new AppErrorException(AppErrorException.synchronization);
		}
		
		logger.debug("Adding link Id {} between Entity Id {} and its parent Id {}", id, entity.getId(), entity.getParentId());
	}
	
	private Set<DiseaseSynonym> validateSynonyms(String value, Set<DiseaseSynonym> entities) {
		
		if (entities == null) {
			return new HashSet<DiseaseSynonym>(Arrays.asList(new DiseaseSynonym(value)));
		}
		
		boolean added = false;
		
		Set<DiseaseSynonym> validatedEntities = new HashSet<>();
		
		for (DiseaseSynonym entity : entities) {
			
			if (entity.getName().equals(value)) {
				
				added = true;
				validatedEntities.add(entity);
			} else {
				if (entity.getName().toUpperCase().equals(value.toUpperCase()) || entity.getName().isEmpty()) {
					// discarded: same as disease name but different case sensitive approach *OR* name is empty
				} else {
					validatedEntities.add(entity);
				}
			}
		}
		
		if (!added) {
			validatedEntities.add(new DiseaseSynonym(value));
		}
		
		return validatedEntities;
	}
	
	private void insertSynonyms(DiseaseEntity entity, DatabaseExecutor databaseExecutor) throws AppErrorException, AppException, SQLException {
		
		entity.setDiseaseSynonyms(validateSynonyms(entity.getName(), entity.getDiseaseSynonyms()));
		diseaseSynonymModel.insert(entity.getId(), entity.getDiseaseSynonyms(), entity.getCreatedByUserId(), databaseExecutor);
	}
	
	private void insertMedDRAs(DiseaseEntity entity, DatabaseExecutor databaseExecutor) throws AppErrorException, AppException, SQLException {
		
		if (entity.getDiseaseMedDRAs() != null) {
            diseaseMedDRAModel.insert(entity.getId(), entity.getDiseaseMedDRAs(), entity.getCreatedByUserId(), databaseExecutor);
        }
	}
	
	private void insertTherapeuticActivities(DiseaseEntity entity, DatabaseExecutor databaseExecutor) throws AppErrorException, AppException, SQLException {
		
		if (entity.getDiseaseTherapeuticActivities() != null) {
			// TODO will be implemented (uncommented) after Therapeutic Activity is included in a Service
			//diseaseTherapeuticActivityModel.insert(entity.getId(), entity.getDiseaseTherapeuticActivities(), entity.getCreatedByUserId(), databaseExecutor);
        }
	}
	
	@Override
	public long insert(DiseaseEntity entity, long userId, DatabaseExecutor databaseExecutor) throws AppErrorException, AppException, LicenseException, SQLException {
		
		Constraint.checkConstraintsForInserting(entity, userId, databaseExecutor);
		
		entity.setCreatedByUserId(userId);
		entity.setUpdatedByUserId(userId);
		
		insertEntity(entity, databaseExecutor);
		insertParent(entity, databaseExecutor);
		insertSynonyms(entity, databaseExecutor);
		insertMedDRAs(entity, databaseExecutor);
		insertTherapeuticActivities(entity, databaseExecutor);
		
		logger.info("ADDED Entity Id {}", entity.getId());
		
		return entity.getId();
	}
	
	private boolean updateSynonym(DiseaseEntity entity, DatabaseExecutor databaseExecutor) throws AppErrorException, AppException, SQLException {
		
		boolean success = diseaseSynonymModel.update(entity.getId(), entity.getDiseaseSynonyms(), entity.getUpdatedByUserId(), databaseExecutor);
		
		if (success) {
			logger.debug("Updating 'Synonym list'. Entity Id {}", entity.getId());
		}
		
		return success;
	}
	
	private boolean updateMedDRA(DiseaseEntity entity, DatabaseExecutor databaseExecutor) throws AppErrorException, AppException, SQLException {
		
		boolean success = diseaseMedDRAModel.update(entity.getId(), entity.getDiseaseMedDRAs(), entity.getUpdatedByUserId(), databaseExecutor);
		
		if (success) {
			logger.debug("Updating 'MedDRA list'. Entity Id {}", entity.getId());
		}
		
		return success;
	}
	
	private boolean updateTherapeuticActivity(DiseaseEntity entity, DatabaseExecutor databaseExecutor) throws AppErrorException, AppException, SQLException {
		
		// TODO will be implemented (replaced) after Therapeutic Activity is included in a Service
		boolean success = false;
		//boolean success = diseaseTherapeuticActivityModel.update(entity.getId(), entity.getDiseaseTherapeuticActivities(), entity.getUpdatedByUserId(), databaseExecutor);
		
		if (success) {
			logger.debug("Updating 'Therapeutic Activity list'. Entity Id {}", entity.getId());
		}
		
		return success;
	}
	
	private boolean updateColumn(long id, String columnName, String newValue, String currentValue, DatabaseExecutor databaseExecutor) throws AppErrorException, SQLException {
		
		if (Utils.equals(newValue, currentValue)) {
			return false;
		}
		
		String query = Query.updateColumn_QUERY;
		
		query = query.replace("{columnName}", columnName.toLowerCase());
		
		Object[] parameters = new Object[]{newValue, id};
		
		boolean success = databaseExecutor.persistQuery(query, parameters);
		
		if (!success) {
			throw new AppErrorException(AppErrorException.update);
		}
		
		if (!Synchronization.trackUpdate(tableName, id, columnName.toUpperCase(), databaseExecutor)) {
			throw new AppErrorException(AppErrorException.synchronization);
		}
		
		logger.debug("Updating '{}'. Entity Id {}", columnName, id);
		
		return true;
	}
	
	private boolean updateName(long id, String newValue, String currentValue, DatabaseExecutor databaseExecutor) throws AppErrorException, AppException, SQLException {
		
		return updateColumn(id, "Name", newValue, currentValue, databaseExecutor);
	}
	
	private boolean updateComments(long id, String newValue, String currentValue, DatabaseExecutor databaseExecutor) throws AppErrorException, SQLException {
		
		return updateColumn(id, "Comments", newValue, currentValue, databaseExecutor);
	}
	
	private void updateUserAndDate(DiseaseEntity entity, DatabaseExecutor databaseExecutor) throws AppErrorException, SQLException {
		
		String query = Query.update_QUERY;
		
		query = query.replace("{timestamp}", UtilsDatabase.SYSDATE);
		
		Object[] parameters = new Object[]{entity.getUpdatedByUserId(), entity.getId()};
		
		boolean success = databaseExecutor.persistQuery(query, parameters);
		
    	if (!success) {
    		throw new AppErrorException(AppErrorException.update);
    	}
    	
    	logger.debug("Updating 'updatedByUserId' and 'updatedOn' fields. Entity Id {}", entity.getId());
	}
	
	@Override
	public void update(DiseaseEntity entity, long userId, DatabaseExecutor databaseExecutor) throws AppErrorException, AppException, LicenseException, SQLException {
		
		Constraint.checkConstraintsForUpdating(entity, userId);
		
		entity.setDiseaseSynonyms(validateSynonyms(entity.getName(), entity.getDiseaseSynonyms()));
		
		DiseaseEntity current = get(entity.getId(), databaseExecutor);
		
		if (Utils.isNotNullButEmpty(entity.getComments())) {
			entity.setComments(null);
		}
		
		if (entity.equals(current)) { // no significant changes
			throw new AppException(AppException.nothingToUpdate);
		}
		
		entity.setUpdatedByUserId(userId);
		
		boolean synonymUpdate = updateSynonym(entity, databaseExecutor);
		boolean medDRAUpdate = updateMedDRA(entity, databaseExecutor);
		boolean therapeuticActivityUpdate = updateTherapeuticActivity(entity, databaseExecutor);
		boolean nameUpdate = updateName(entity.getId(), entity.getName(), current.getName(), databaseExecutor);
		boolean commentsUpdate = updateComments(entity.getId(), entity.getComments(), current.getComments(), databaseExecutor);
		
		if (synonymUpdate || medDRAUpdate || therapeuticActivityUpdate || nameUpdate || commentsUpdate) {
			updateUserAndDate(entity, databaseExecutor);
		} else {
			throw new AppErrorException(AppErrorException.equalsIssue);
		}
		
		logger.info("UPDATED Entity Id {}", entity.getId());
	}
	
	private List<Long> getSelfId(long diseaseId, long userId, DatabaseExecutor databaseExecutor) throws AppErrorException, SQLException {
		
		String query = Query.getSelfId_QUERY;
		
		Object[] parameters = new Object[]{diseaseId};
		
		ResultObject resultObject = databaseExecutor.retrieveQuery(query, parameters);
		
	    if (resultObject.getRows().isEmpty()) {
	    	throw new AppErrorException(AppErrorException.hierarquicalIssue);
	    }
		
	    List<Long> list = new ArrayList<>();
	    
		for (RowObject rowObject : resultObject.getRows()) {
			
			list.add( Long.parseLong( UtilsData.getValue(rowObject.getRowValue(), "DISEASE_SELF_ID") ) );
		}
		
	   return list;
	}
	
	private void deleteAsChild(long diseaseId, long userId, DatabaseExecutor databaseExecutor) throws AppErrorException, SQLException {
		
		List<Long> listId = getSelfId(diseaseId, userId, databaseExecutor);
		
		if (listId.isEmpty()) {
			throw new AppErrorException(AppErrorException.codeIssue);
		}
		
		for (long id : listId) {
			
			String query = Query.deleteAsChild_QUERY;
			
			Object[] parameters = new Object[]{id};
			
			boolean success = databaseExecutor.persistQuery(query, parameters);
			
			if (!success) {
	    		throw new AppErrorException(AppErrorException.deleteParentLink);
			}
			
			if (!Synchronization.trackDelete(tableNameSelf, id, databaseExecutor)) {
				throw new AppErrorException(AppErrorException.synchronization);
			}
			
			logger.debug("Deleting link Id {} for Entity Id {}", id, diseaseId);
		}
	}
	
	@Override
	public void delete(long id, long userId, DatabaseExecutor databaseExecutor) throws AppErrorException, AppException, LicenseException, SQLException {
		
		Constraint.checkConstraintsForDeleting(id, userId, databaseExecutor);
		
		deleteAsChild(id, userId, databaseExecutor);
		diseaseMedDRAModel.delete(id, userId, databaseExecutor); // response not needed
		diseaseSynonymModel.delete(id, userId, databaseExecutor); // response not needed
		diseaseTherapeuticActivityModel.delete(id, userId, databaseExecutor); // response not needed
		
		String query = Query.delete_QUERY;
		
		Object[] parameters = new Object[]{id};
		
		boolean success = databaseExecutor.persistQuery(query, parameters);
		
    	if (!success) {
    		throw new AppErrorException(AppErrorException.delete);
    	}
		
		if (!Synchronization.trackDelete(tableName, id, databaseExecutor)) {
			throw new AppErrorException(AppErrorException.synchronization);
		}
		
    	logger.info("DELETED Entity Id {}", id);
	}
*/
}
