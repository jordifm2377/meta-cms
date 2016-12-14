package com.thomsonreuters.controller;

import com.fasterxml.jackson.databind.ObjectMapper;

import com.google.inject.Inject;
import com.google.inject.Singleton;

import com.thomsonreuters.cms.db.DatabaseConnector;
import com.thomsonreuters.cms.db.DatabaseExecutor;
import com.thomsonreuters.cms.exception.AppErrorException;
import com.thomsonreuters.cms.exception.AppException;
import com.thomsonreuters.datamodel.AttributeDef;
import com.thomsonreuters.datamodel.EntityAttributeDef;
import com.thomsonreuters.datamodel.EntityDef;
import com.thomsonreuters.datamodel.LookupDef;
import com.thomsonreuters.datamodel.LookupDef.LookupValueDef;
import com.thomsonreuters.datamodel.RelationDef;
import com.thomsonreuters.datamodel.client.ApiEntityClient;
import com.thomsonreuters.datamodel.client.AttributeDefClient;
import com.thomsonreuters.datamodel.client.EntityDefClient;
import com.thomsonreuters.datamodel.client.LookupDefClient;
import com.thomsonreuters.model.AttributeModel;
import com.thomsonreuters.model.AttributeModelImpl;
import com.thomsonreuters.model.EntityAttributeModel;
import com.thomsonreuters.model.EntityAttributeModelImpl;
import com.thomsonreuters.model.EntityModel;
import com.thomsonreuters.model.EntityModelImpl;
import com.thomsonreuters.model.LookupModel;
import com.thomsonreuters.model.LookupModelImpl;
import com.thomsonreuters.model.RelationModel;
import com.thomsonreuters.model.RelationModelImpl;

import java.io.IOException;
import java.sql.SQLException;
import java.util.List;

import org.codehaus.jettison.json.JSONException;
import org.codehaus.jettison.json.JSONObject;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

@Singleton
public class ControllerImpl2 implements Controller2 {
	
	private static final Logger logger = LoggerFactory.getLogger("ControllerImpl2");
	private ObjectMapper mapper = new ObjectMapper();
	private AttributeModel attrModel = new AttributeModelImpl();
	private EntityModel entityModel = new EntityModelImpl();
	private EntityAttributeModel entityAttrModel = new EntityAttributeModelImpl();
	private RelationModel relationModel = new RelationModelImpl();
	private LookupModel lookupModel = new LookupModelImpl();
    private DatabaseExecutor dbExec;

    @Inject    
	public ControllerImpl2(DatabaseConnector databaseConnector) {
    	try {
			this.dbExec = databaseConnector.getDatabaseExecutor(true);
		} catch (SQLException e) {
			logger.error(e.getMessage(), e);
		}
	}

	@Override
	public EntityDefClient getEntityDefinitionSummary(String userId, long entityId, int deep) {
		EntityDefClient entDefCli = new EntityDefClient();
		try {
			EntityDef entDef = entityModel.getEntity(userId, entityId, dbExec);
			entDefCli.setId(entDef.getId());
			entDefCli.setName(entDef.getName());
			entDefCli.setCaption(entDef.getCaption());
			entDefCli.setDescription(entDef.getDescription());
			entDefCli.setTag(entDef.getTag());
			entDefCli.setEntityGroup(entDef.getGroupId());
			if(entDef.getGroupId() > 1 || deep == 0) {
				List<EntityAttributeDef> eaDefList = entityAttrModel.getEntityAttributeDefListForEntity(userId, entityId, dbExec);
				if(eaDefList.size() > 0) {
					for(EntityAttributeDef eaDef:eaDefList) {
						if(eaDef.getAttrId() > 0) {
							AttributeDefClient aDefCli = getEntityAttribute(userId, eaDef);
							List<AttributeDefClient> attrList = entDefCli.getAttributes();
							attrList.add(aDefCli);
							entDefCli.setAttributes(attrList);
						} else if(eaDef.getRelId() > 0) {
							EntityDefClient entDefChildCli = getEntityRelation(userId, eaDef, deep);
							List<EntityDefClient> entList = entDefCli.getEntities();
							entList.add(entDefChildCli);
							entDefCli.setEntities(entList);
						}
						
					}
				}
			}
		} catch (AppErrorException | AppException | SQLException e) {
			logger.debug(e.getMessage(), e);
			return null;
		}
		return entDefCli;
	}

	private EntityDefClient getEntityRelation(String userId, EntityAttributeDef eaDef, int deep)
			throws AppErrorException, AppException, SQLException {
		RelationDef rDef = relationModel.getRelation(userId, eaDef.getRelId(), dbExec);
		EntityDefClient entDefChildCli = getEntityDefinitionSummary(userId, rDef.getChildId(), ++deep);
		String renderString = "E."+rDef.getName()+"."+rDef.getParentId()+"."+rDef.getChildId()+"."+rDef.getId()+"."+rDef.getOrderType(); //Afegir el id de values quan sigui un update!!
		entDefChildCli.setRenderInformation(renderString);
		if(rDef.getTag() != null && !"".equalsIgnoreCase(rDef.getTag())) {
			entDefChildCli.setTag(rDef.getTag());
		} 
		return entDefChildCli;
	}

	private AttributeDefClient getEntityAttribute(String userId, EntityAttributeDef eaDef)
			throws AppErrorException, AppException, SQLException {
		AttributeDef aDef = attrModel.getAttribute(userId, eaDef.getAttrId(), dbExec);
		AttributeDefClient aDefCli = new AttributeDefClient();
		String renderString = "A."+aDef.getName()+"."+eaDef.getAttrId()+"."+eaDef.getEntityId()+"."+eaDef.getId()+"."+eaDef.getMandatory(); //Afegir el id de values quan sigui un update!!		
		aDefCli.setId(aDef.getId());
		aDefCli.setName(aDef.getName());
		aDefCli.setCaption(aDef.getCaption());
		aDefCli.setRenderInformation(renderString);
		try {
			aDefCli.setDescription(aDef.getDescription());
		} catch(Exception e) {
			aDefCli.setDescription("");
		}
		aDefCli.setTag(aDef.getTag());
		aDefCli.setType(aDef.getType());
		if("L".equalsIgnoreCase(aDef.getType())) { //Add lookup information
			LookupDef lDef = lookupModel.getLookup(userId, aDef.getLookupId(), dbExec);
			LookupDefClient lDefCli = new LookupDefClient();
			lDefCli.setId(lDef.getId());
			lDefCli.setName(lDef.getName());
			lDefCli.setType(lDef.getType());
			lDefCli.setDefaultId(lDef.getDefaultId());
			if(lDef.getLookupValues().size() > 0) {
				for(LookupValueDef lDefVal:lDef.getLookupValues()) {
					lDefCli.addLookupValue(lDefVal.getId(), lDefVal.getLookupId(), lDefVal.getOrder(), lDefVal.getValue(), lDefVal.getCaption());
				}
			}
			aDefCli.setLookup(lDefCli);
		}
		return aDefCli;
	}

	@Override
	public EntityDefClient getEntityDefinitionSummary(String userId, String entityId) {
		return getEntityDefinitionSummary(userId, Long.valueOf(entityId), 0);
	}

	@Override
	public EntityDefClient newEntity(String userId, String entityId) {
		return getEntityDefinitionSummary(userId, Long.valueOf(entityId), 0);
	}

	@Override
	public EntityDefClient addEntity(String userId, String entityId, String payload) {
		try {
			ApiEntityClient aec = mapper.readValue(payload, ApiEntityClient.class);
			EntityDefClient entityMetadata = getEntityDefinitionSummary(userId, Long.valueOf(entityId), 0);
			//Check entity type... can only be 1 or 2 !!
			if(entityMetadata.getEntityGroup() >= 3) {
				return null; //this should not be possible, main entity MUST be of type 1 or 2... return error !!!
			}
			else {
				if(aec.getEntities().size() > 0) {
					ApiEntityClient aec2 = aec.getEntities().get(0); //It shouldn't be a list... as for now always add a single sub-entity
					EntityDefClient entityMetadata2 = getEntityDefinitionSummary(userId, Long.valueOf(aec2.getEntityId()), 0);
					if(entityMetadata2.getEntityGroup() == 3) { //It's M-N relation, it should have a child of groupId 1 or 2
						if(aec2.getEntities().size() > 0) {
							ApiEntityClient aec3 = aec2.getEntities().get(0); //It shouldn't be a list... as for now always add a single sub-entity
							EntityDefClient entityMetadata3 = getEntityDefinitionSummary(userId, Long.valueOf(aec3.getEntityId()), 0);
							if(entityMetadata3.getEntityGroup() == 1) {
								
							}
							else if(entityMetadata3.getEntityGroup() == 2) {
								
							}
						} 
						else { //It's an error... an entity of group type 3 MUST have an entity of type 1 or 2 attached!
							return null;
						}
					}
					else if(entityMetadata2.getEntityGroup() == 1) { //It's 1-1 or 1-N with entity 1
						
					}
					else if(entityMetadata2.getEntityGroup() == 2) { //It's 1-1 or 1-N with entity 2
						
					}					
				} 
				else { //just insert one entity
				}
			}
		} catch (IOException e) {
			e.printStackTrace();
		}
		return null;
	}

}