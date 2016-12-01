package com.thomsonreuters.model;

import com.google.inject.Singleton;

import com.thomsonreuters.cms.db.DatabaseExecutor;
import com.thomsonreuters.cms.db.ResultObject;
import com.thomsonreuters.cms.db.RowObject;
import com.thomsonreuters.cms.exception.AppErrorException;
import com.thomsonreuters.cms.exception.AppException;
import com.thomsonreuters.datamodel.EntityAttributeDef;
import com.thomsonreuters.query.Query;

import java.sql.SQLException;
import java.util.ArrayList;
import java.util.List;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

@Singleton
public class EntityAttributeModelImpl implements EntityAttributeModel {
	
	private static final Logger logger = LoggerFactory.getLogger("EntityAttributeModelImpl");

	@Override
	public List<Long> search(String searchTerm, long userId, DatabaseExecutor databaseExecutor) throws SQLException {
		// TODO Auto-generated method stub
		return null;
	}

	@Override
	public EntityAttributeDef getEntityAttributeDef(String userId, long entityAttrId, DatabaseExecutor databaseExecutor)
		throws AppErrorException, AppException, SQLException {

		String query = Query.GET_ENTITY_ATTRIBUTE;
        Object[] parameters = new Object[]{entityAttrId};

        ResultObject res = databaseExecutor.retrieveQuery(query, parameters);

        if(res.getRows().size() <= 0) {
        	throw new AppErrorException(AppErrorException.missingTerm);
        }
        logger.debug("Get entity-attribute Id {}", entityAttrId);
        return parseEntityAttributeRow(res.getRows().get(0));

	}

	@Override
	public List<EntityAttributeDef> getEntityAttributeDefList(String userId, DatabaseExecutor databaseExecutor)
		throws AppErrorException, AppException, SQLException {
		
		String query = Query.GET_ENTITIES_ATTRIBUTES;

        ResultObject res = databaseExecutor.retrieveQuery(query, new Object[]{});
        if(res.getRows().size() <= 0) {
        	return new ArrayList<>();
        }
        List<EntityAttributeDef> entityAttrDefList = new ArrayList<>();
        res.getRows().forEach( row -> entityAttrDefList.add(parseEntityAttributeRow(row)));
        logger.debug("Get entities-attributes");
        
        return entityAttrDefList;

	}

	@Override
	public List<EntityAttributeDef> getEntityAttributeDefListForEntity(String userId, long entityId, DatabaseExecutor databaseExecutor)
		throws AppErrorException, AppException, SQLException {

		String query = Query.GET_ENTITY_ATTRIBUTES_BY_ENTITY;
        Object[] parameters = new Object[]{entityId};

        ResultObject res = databaseExecutor.retrieveQuery(query, parameters);

        if(res.getRows().size() <= 0) {
        	return new ArrayList<>();
        }
        logger.debug("Get entity-attribute of entity Id {}", entityId);
        List<EntityAttributeDef> entityAttrDefList = new ArrayList<>();
        res.getRows().forEach( row -> entityAttrDefList.add(parseEntityAttributeRow(row)));
        logger.debug("Get entities-attributes");
        
        return entityAttrDefList;
	}

	@Override
	public long insertEntityAttribute(String userId, EntityAttributeDef entityAttrDef, DatabaseExecutor databaseExecutor)
		throws AppErrorException, AppException, SQLException {

        String query = Query.INSERT_ENTITY_ATTRIBUTE;
        Object[] parameters = new Object[]{entityAttrDef.getEntityId(), entityAttrDef.getAttrId(), entityAttrDef.getRelId() 
        		, entityAttrDef.getRow(), entityAttrDef.getColumn(), entityAttrDef.getWidth(), entityAttrDef.getHeight()
        		, entityAttrDef.getImgWidth(), entityAttrDef.getImgHeight(), entityAttrDef.getOrderKey(), entityAttrDef.getMandatory()};

        boolean success = databaseExecutor.persistQuery(query, parameters);

        if (!success) {
        	throw new AppErrorException(AppErrorException.add);
        }
        logger.debug("Adding entity-attribute Id {}", entityAttrDef.getId());
		return 0;
		
	}

	@Override
	public long updateEntityAttribute(String userId, EntityAttributeDef entityAttrDef, DatabaseExecutor databaseExecutor)
		throws AppErrorException, AppException, SQLException {

        String query = Query.UPDATE_ENTITY_ATTRIBUTE;
        Object[] parameters = new Object[]{entityAttrDef.getEntityId(), entityAttrDef.getAttrId()
        		, entityAttrDef.getRelId(),  entityAttrDef.getRow(), entityAttrDef.getColumn()
        		, entityAttrDef.getWidth(), entityAttrDef.getHeight(), entityAttrDef.getImgWidth() 
        		, entityAttrDef.getImgHeight(), entityAttrDef.getOrderKey(), entityAttrDef.getMandatory()
        		, entityAttrDef.getId()};

        boolean success = databaseExecutor.persistQuery(query, parameters);

        if (!success) {
        	throw new AppErrorException(AppErrorException.update);
        }
        logger.debug("Updating entity-attribute Id {}", entityAttrDef.getId());
		return 0;

	}

	@Override
	public long deleteEntityAttribute(String userId, long entityAttrId, DatabaseExecutor databaseExecutor)
		throws AppErrorException, AppException, SQLException {
        String query = Query.DELETE_ENTITY_ATTRIBUTE;
        Object[] parameters = new Object[]{entityAttrId};

        boolean success = databaseExecutor.persistQuery(query, parameters);

        if (!success) {
        	throw new AppErrorException(AppErrorException.delete);
        }
        logger.debug("Deleting entity-attribute Id {}", entityAttrId);

		return 0;

	}

	@Override
	public long enableEntityAttribute(String userId, long entityAttrId, DatabaseExecutor databaseExecutor)
			throws AppErrorException, AppException, SQLException {
        String query = Query.CHANGE_ENTITY_ATTRIBUTE_STATUS;
        Object[] parameters = new Object[]{"Y", entityAttrId};

        boolean success = databaseExecutor.persistQuery(query, parameters);

        if (!success) {
        	throw new AppErrorException(AppErrorException.update);
        }
        logger.debug("Enabling entity-attribute Id {}", entityAttrId);

		return 0;
	}

	@Override
	public long disableEntityAttribute(String userId, long entityAttrId, DatabaseExecutor databaseExecutor)
			throws AppErrorException, AppException, SQLException {
        String query = Query.CHANGE_ENTITY_ATTRIBUTE_STATUS;
        Object[] parameters = new Object[]{"N", entityAttrId};

        boolean success = databaseExecutor.persistQuery(query, parameters);

        if (!success) {
        	throw new AppErrorException(AppErrorException.update);
        }
        logger.debug("Disabling entity-attribute Id {}", entityAttrId);

		return 0;
	}
	
	private EntityAttributeDef parseEntityAttributeRow(RowObject row) {
		EntityAttributeDef entityAttribDef = new EntityAttributeDef();
		entityAttribDef.setId((Long)row.getRowValue().get("id"));
		entityAttribDef.setEntityId((Long)row.getRowValue().getOrDefault("entity_id", 0));
		entityAttribDef.setAttrId((Integer)row.getRowValue().getOrDefault("atri_id", 0));
		entityAttribDef.setRelId((Long)row.getRowValue().getOrDefault("rel_id", 0));
		entityAttribDef.setRow((Long)row.getRowValue().getOrDefault("position_row", 0));
		entityAttribDef.setColumn((Long)row.getRowValue().getOrDefault("position_column", 0));
		try{
			entityAttribDef.setWidth((Integer)row.getRowValue().getOrDefault("width", 0));
		} catch(Exception e) {
			entityAttribDef.setWidth(0);
		}
		try{
			entityAttribDef.setHeight((Integer)row.getRowValue().getOrDefault("height", 0));
		} catch(Exception e) {
			entityAttribDef.setHeight(0);
		}

		try{
			entityAttribDef.setOrderKey((Long)row.getRowValue().getOrDefault("order_key", 0));
		} catch(Exception e) {
			entityAttribDef.setOrderKey(0);
		}
		entityAttribDef.setMandatory((String)row.getRowValue().getOrDefault("mandatory", "N"));
		entityAttribDef.setEnabled((String)row.getRowValue().getOrDefault("enabled", "N"));
		return entityAttribDef;
	}

}
