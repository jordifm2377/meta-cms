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
import com.thomsonreuters.datamodel.RelationDef;
import com.thomsonreuters.model.AttributeModel;
import com.thomsonreuters.model.AttributeModelImpl;
import com.thomsonreuters.model.EntityAttributeModel;
import com.thomsonreuters.model.EntityAttributeModelImpl;
import com.thomsonreuters.model.EntityModel;
import com.thomsonreuters.model.EntityModelImpl;
import com.thomsonreuters.model.RelationModel;
import com.thomsonreuters.model.RelationModelImpl;

import java.io.IOException;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.List;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

@Singleton
public class ControllerImpl implements Controller {
	
	private static final Logger logger = LoggerFactory.getLogger("ControllerImpl");
	private ObjectMapper mapper = new ObjectMapper();
	private AttributeModel attrModel = new AttributeModelImpl();
	private EntityModel entityModel = new EntityModelImpl();
	private EntityAttributeModel entityAttrModel = new EntityAttributeModelImpl();
	private RelationModel relationModel = new RelationModelImpl();
    private DatabaseExecutor dbExec;
    
    @Inject
	public ControllerImpl(DatabaseConnector databaseConnector) {
    	try {
			this.dbExec = databaseConnector.getDatabaseExecutor(true);
		} catch (SQLException e) {
			logger.error(e.getMessage(), e);
		}
	}

	private long stringToLong(String number) {
		return Long.valueOf(number);
	}

	@Override
	public AttributeDef getAttribute(String userId, String attrId) {
		try {
			return attrModel.getAttribute(userId, stringToLong(attrId), dbExec);
		} catch(AppErrorException | AppException | SQLException e) {
			logger.info(e.getMessage(), e);
			return null;
		}
	}

	@Override
	public List<AttributeDef> getAttributes(String userId) {
		try {
			return attrModel.getAttributeList(userId, dbExec);
		} catch(AppErrorException | AppException | SQLException e) {
			logger.info(e.getMessage(), e);
			return new ArrayList<>();
		}
	}

	@Override
	public long addAttribute(String userId, String attrContent) {
		try {
			AttributeDef attrDef = mapper.readValue(attrContent, AttributeDef.class);
			attrModel.insertAttribute(userId, attrDef, dbExec);
			
		} catch(AppErrorException | AppException | IOException | SQLException e) {
			logger.info(e.getMessage(), e);
		}
		return 0;
	}

	@Override
	public long updateAttribute(String userId, String attrContent) {
		try {
			AttributeDef attrDef = mapper.readValue(attrContent, AttributeDef.class);
			attrModel.updateAttribute(userId, attrDef, dbExec);
			
		} catch(AppErrorException | AppException | IOException | SQLException e) {
			logger.info(e.getMessage(), e);
		}

		return 0;
	}

	@Override
	public long enableAttribute(String userId, String attrId) {
		try {
			attrModel.enableAttribute(userId, stringToLong(attrId), dbExec);
			
		} catch(AppErrorException | AppException | SQLException e) {
			logger.info(e.getMessage(), e);
		}
		return 0;
	}

	@Override
	public long disableAttribute(String userId, String attrId) {
		try {
			attrModel.disableAttribute(userId, stringToLong(attrId), dbExec);
			
		} catch(AppErrorException | AppException | SQLException e) {
			logger.info(e.getMessage(), e);
		}
		return 0;
	}

	@Override
	public long deleteAttribute(String userId, String attrId) {
		try {
			attrModel.deleteAttribute(userId, stringToLong(attrId), dbExec);
			
		} catch(AppErrorException | AppException | SQLException e) {
			logger.info(e.getMessage(), e);
		}
		return 0;
	}

	@Override
	public EntityDef getEntity(String userId, String entityId) {
		try {
			return entityModel.getEntity(userId, stringToLong(entityId), dbExec);
		} catch(AppErrorException | AppException | SQLException e) {
			logger.info(e.getMessage(), e);
			return null;
		}
	}

	@Override
	public List<EntityDef> getEntities(String userId) {
		try {
			return entityModel.getEntityList(userId, dbExec);
		} catch(AppErrorException | AppException | SQLException e) {
			logger.info(e.getMessage(), e);
			return new ArrayList<>();
		}
	}

	@Override
	public long addEntity(String userId, String entityContent) {
		try {
			EntityDef entityDef = mapper.readValue(entityContent, EntityDef.class);
			entityModel.insertEntity(userId, entityDef, dbExec);
			
		} catch(AppErrorException | AppException | IOException | SQLException e) {
			logger.info(e.getMessage(), e);
		}

		return 0;
	}

	@Override
	public long updateEntity(String userId, String entityContent) {
		try {
			EntityDef entityDef = mapper.readValue(entityContent, EntityDef.class);
			entityModel.updateEntity(userId, entityDef, dbExec);
			
		} catch(AppErrorException | AppException | IOException | SQLException e) {
			logger.info(e.getMessage(), e);
		}

		return 0;
	}

	@Override
	public long enableEntity(String userId, String entityId) {
		try {
			entityModel.enableEntity(userId, stringToLong(entityId), dbExec);
			
		} catch(AppErrorException | AppException | SQLException e) {
			logger.info(e.getMessage(), e);
		}
		return 0;
	}

	@Override
	public long disableEntity(String userId, String entityId) {
		try {
			entityModel.disableEntity(userId, stringToLong(entityId), dbExec);
			
		} catch(AppErrorException | AppException | SQLException e) {
			logger.info(e.getMessage(), e);
		}
		return 0;
	}

	@Override
	public long deleteEntity(String userId, String entityId) {
		try {
			entityModel.deleteEntity(userId, stringToLong(entityId), dbExec);
			
		} catch(AppErrorException | AppException | SQLException e) {
			logger.info(e.getMessage(), e);
		}
		return 0;
	}

	
	@Override
	public EntityAttributeDef getEntityAttribute(String userId, String entityAttrId) {
		try {
			return entityAttrModel.getEntityAttributeDef(userId, stringToLong(entityAttrId), dbExec);
		} catch(AppErrorException | AppException | SQLException e) {
			logger.info(e.getMessage(), e);
			return null;
		}
	}

	@Override
	public List<EntityAttributeDef> getEntitiesAttributes(String userId) {
		try {
			return entityAttrModel.getEntityAttributeDefList(userId, dbExec);
		} catch(AppErrorException | AppException | SQLException e) {
			logger.info(e.getMessage(), e);
			return new ArrayList<>();
		}
	}

	@Override
	public long addEntityAttribute(String userId, String entityAttrContent) {
		try {
			EntityAttributeDef entityAttrDef = mapper.readValue(entityAttrContent, EntityAttributeDef.class);
			entityAttrModel.insertEntityAttribute(userId, entityAttrDef, dbExec);
			
		} catch(AppErrorException | AppException | IOException | SQLException e) {
			logger.info(e.getMessage(), e);
		}
		return 0;
	}

	@Override
	public long updateEntityAttribute(String userId, String entityAttrContent) {
		try {
			EntityAttributeDef entityAttrDef = mapper.readValue(entityAttrContent, EntityAttributeDef.class);
			entityAttrModel.updateEntityAttribute(userId, entityAttrDef, dbExec);
			
		} catch(AppErrorException | AppException | IOException | SQLException e) {
			logger.info(e.getMessage(), e);
		}
		return 0;
	}

	@Override
	public long enableEntityAttribute(String userId, String entityAttrId) {
		try {
			entityAttrModel.enableEntityAttribute(userId, stringToLong(entityAttrId), dbExec);
			
		} catch(AppErrorException | AppException | SQLException e) {
			logger.info(e.getMessage(), e);
		}
		return 0;
	}

	@Override
	public long disableEntityAttribute(String userId, String entityAttrId) {
		try {
			entityAttrModel.disableEntityAttribute(userId, stringToLong(entityAttrId), dbExec);
			
		} catch(AppErrorException | AppException | SQLException e) {
			logger.info(e.getMessage(), e);
		}
		return 0;
	}

	@Override
	public long deleteEntityAttribute(String userId, String entityAttrId) {
		try {
			entityAttrModel.deleteEntityAttribute(userId, stringToLong(entityAttrId), dbExec);
			
		} catch(AppErrorException | AppException | SQLException e) {
			logger.info(e.getMessage(), e);
		}
		return 0;
	}

	@Override
	public RelationDef getRelation(String userId, String relationId) {
		try {
			return relationModel.getRelation(userId, stringToLong(relationId), dbExec);
		} catch(AppErrorException | AppException | SQLException e) {
			logger.info(e.getMessage(), e);
			return null;
		}
	}

	@Override
	public List<RelationDef> getRelations(String userId) {
		try {
			return relationModel.getRelationList(userId, dbExec);
		} catch(AppErrorException | AppException | SQLException e) {
			logger.info(e.getMessage(), e);
			return new ArrayList<>();
		}
	}

	@Override
	public long addRelation(String userId, String relationContent) {
		try {
			RelationDef relationDef = mapper.readValue(relationContent, RelationDef.class);
			relationModel.insertRelation(userId, relationDef, dbExec);
			
		} catch(AppErrorException | AppException | IOException | SQLException e) {
			logger.info(e.getMessage(), e);
		}
		return 0;
	}

	@Override
	public long updateRelation(String userId, String relationContent) {
		try {
			RelationDef relationDef = mapper.readValue(relationContent, RelationDef.class);
			relationModel.updateRelation(userId, relationDef, dbExec);
			
		} catch(AppErrorException | AppException | IOException | SQLException e) {
			logger.info(e.getMessage(), e);
		}
		return 0;
	}

	@Override
	public long enableRelation(String userId, String relationId) {
		try {
			relationModel.enableRelation(userId, stringToLong(relationId), dbExec);
			
		} catch(AppErrorException | AppException | SQLException e) {
			logger.info(e.getMessage(), e);
		}
		return 0;
	}

	@Override
	public long disableRelation(String userId, String relationId) {
		try {
			relationModel.disableRelation(userId, stringToLong(relationId), dbExec);
			
		} catch(AppErrorException | AppException | SQLException e) {
			logger.info(e.getMessage(), e);
		}
		return 0;
	}

	@Override
	public long deleteRelation(String userId, String relationId) {
		try {
			relationModel.deleteRelation(userId, stringToLong(relationId), dbExec);
			
		} catch(AppErrorException | AppException | SQLException e) {
			logger.info(e.getMessage(), e);
		}
		return 0;
	}


}