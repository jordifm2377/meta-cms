package com.thomsonreuters.model;

import com.google.inject.Singleton;

import com.thomsonreuters.cms.db.DatabaseExecutor;
import com.thomsonreuters.cms.db.ResultObject;
import com.thomsonreuters.cms.db.RowObject;
import com.thomsonreuters.cms.exception.AppErrorException;
import com.thomsonreuters.cms.exception.AppException;
import com.thomsonreuters.datamodel.EntityDef;
import com.thomsonreuters.query.Query;

import java.sql.SQLException;
import java.util.ArrayList;
import java.util.List;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;

@Singleton
public class EntityModelImpl implements EntityModel {
	
	private static final Logger logger = LoggerFactory.getLogger("EntityModelImpl");

	@Override
	public List<Long> search(String searchTerm, long userId, DatabaseExecutor databaseExecutor) throws SQLException {
		// TODO Auto-generated method stub
		return null;
	}

	@Override
	public EntityDef getEntity(String userId, long entityId, DatabaseExecutor databaseExecutor)
		throws AppErrorException, AppException, SQLException {
		String query = Query.GET_ENTITY;
        Object[] parameters = new Object[]{entityId};

        ResultObject res = databaseExecutor.retrieveQuery(query, parameters);

        if(res.getRows().size() <= 0) {
        	throw new AppErrorException(AppErrorException.missingTerm);
        }
        logger.debug("Get entity Id {}", entityId);
        return parseEntityRow(res.getRows().get(0));
	}

	@Override
	public List<EntityDef> getEntityList(String userId, DatabaseExecutor databaseExecutor)
		throws AppErrorException, AppException, SQLException {
		
		String query = Query.GET_ENTITIES;

        ResultObject res = databaseExecutor.retrieveQuery(query, new Object[]{});
        if(res.getRows().size() <= 0) {
        	return new ArrayList<>();
        }
        List<EntityDef> entityDefList = new ArrayList<>();
        res.getRows().forEach( row -> entityDefList.add(parseEntityRow(row)));
        logger.debug("Get entities");
        
        return entityDefList;

	}

	@Override
	public long insertEntity(String userId, EntityDef entityDef, DatabaseExecutor databaseExecutor) 
		throws AppErrorException, AppException, SQLException {

        String query = Query.INSERT_ENTITY;
        Object[] parameters = new Object[]{entityDef.getName(), entityDef.getCaption(), entityDef.getDescription()
        		, entityDef.getGroupId(), entityDef.getGroupOrder(), entityDef.getTag()};

        boolean success = databaseExecutor.persistQuery(query, parameters);

        if (!success) {
        	throw new AppErrorException(AppErrorException.add);
        }
        logger.debug("Adding entity Id {}", entityDef.getId());
		return 0;

	}

	@Override
	public long updateEntity(String userId, EntityDef entityDef, DatabaseExecutor databaseExecutor)
		throws AppErrorException, AppException, SQLException {
		
        String query = Query.UPDATE_ENTITY;
        Object[] parameters = new Object[]{entityDef.getName(), entityDef.getCaption(), entityDef.getDescription()
        		, entityDef.getGroupId(), entityDef.getGroupOrder(), entityDef.getTag(), entityDef.getId()};

        boolean success = databaseExecutor.persistQuery(query, parameters);

        if (!success) {
        	throw new AppErrorException(AppErrorException.add);
        }
        logger.debug("Updating entity Id {}", entityDef.getId());
		return 0;
	}

	@Override
	public long deleteEntity(String userId, long entityId, DatabaseExecutor databaseExecutor) 
		throws AppErrorException, AppException, SQLException {

        String query = Query.DELETE_ENTITY;
        Object[] parameters = new Object[]{entityId};

        boolean success = databaseExecutor.persistQuery(query, parameters);

        if (!success) {
        	throw new AppErrorException(AppErrorException.add);
        }
        logger.debug("Deleting attribute Id {}", entityId);

		return 0;
	}

	@Override
	public long enableEntity(String userId, long entityId, DatabaseExecutor databaseExecutor)
			throws AppErrorException, AppException, SQLException {
        String query = Query.CHANGE_ENTITY_STATUS;
        Object[] parameters = new Object[]{"Y", entityId};

        boolean success = databaseExecutor.persistQuery(query, parameters);

        if (!success) {
        	throw new AppErrorException(AppErrorException.add);
        }
        logger.debug("Enabling attribute Id {}", entityId);

		return 0;
	}

	@Override
	public long disableEntity(String userId, long entityId, DatabaseExecutor databaseExecutor)
			throws AppErrorException, AppException, SQLException {
        String query = Query.CHANGE_ENTITY_STATUS;
        Object[] parameters = new Object[]{"N", entityId};

        boolean success = databaseExecutor.persistQuery(query, parameters);

        if (!success) {
        	throw new AppErrorException(AppErrorException.add);
        }
        logger.debug("Enabling attribute Id {}", entityId);

		return 0;
	}

	private EntityDef parseEntityRow(RowObject row) {
		EntityDef entityDef = new EntityDef();
		entityDef.setId((Integer) row.getRowValue().get("id"));
		entityDef.setName((String)row.getRowValue().get("name"));
		entityDef.setCaption((String)row.getRowValue().getOrDefault("caption", ""));
		entityDef.setDescription((String)row.getRowValue().getOrDefault("description", ""));
		entityDef.setGroupId((Integer)row.getRowValue().getOrDefault("grp_id", 0));
		entityDef.setGroupOrder((Integer)row.getRowValue().getOrDefault("grp_order", 0));
		entityDef.setTag((String)row.getRowValue().getOrDefault("tag", ""));
		entityDef.setEnabled((String)row.getRowValue().getOrDefault("enabled", "N"));
		return entityDef;
	}

}
