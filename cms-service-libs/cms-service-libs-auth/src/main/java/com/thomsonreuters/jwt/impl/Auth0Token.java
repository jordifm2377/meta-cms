package com.thomsonreuters.jwt.impl;

import java.io.IOException;
import java.security.InvalidKeyException;
import java.security.NoSuchAlgorithmException;
import java.security.SignatureException;
import java.util.Map;

import org.apache.commons.lang.StringUtils;

import com.auth0.jwt.Algorithm;
import com.auth0.jwt.JWTExpiredException;
import com.auth0.jwt.JWTSigner;
import com.auth0.jwt.JWTVerifier;
import com.auth0.jwt.JWTVerifyException;
import com.thomsonreuters.exception.TokenExpiredException;
import com.thomsonreuters.jwt.AuthenticationToken;

public class Auth0Token implements AuthenticationToken {

	private String secret = "secret"; //Get the secret from somewhere ... secure connection ? similar to CGT implementation
	private final String INVALID_TOKEN = "Invalid Token";

	public String generateToken(Map<String, Object> claims) {
		JWTSigner signer = new JWTSigner(secret);
		return signer.sign(claims, new JWTSigner.Options().setAlgorithm(Algorithm.HS256).setIssuedAt(true).setJwtId(true));
	}

	@Override
	public String getHeader(String token)  throws IllegalArgumentException {
		String[] parts = token.split("[.]");
		if(parts.length != 3) { 
			throw new IllegalArgumentException(INVALID_TOKEN);
		}
		return parts[0];
	}

	@Override
	public String getPayload(String token) throws IllegalArgumentException {
		String[] parts = token.split("[.]");
		if(parts.length != 3) { 
			throw new IllegalArgumentException(INVALID_TOKEN);
		}
		return parts[1];
	}

	@Override
	public String getSignature(String token) throws IllegalArgumentException {
		if(isEmpty(token) || token.split("[.]").length != 3) { 
			throw new IllegalArgumentException(INVALID_TOKEN);
		} else {
			String[] parts = token.split("[.]");
			return parts[2];
		}
	}

	@Override
	public Map<String, Object> verifyToken(String token) throws TokenExpiredException {
		String[] parts = token.split("[.]");
		if(parts.length != 3) { 
			throw new IllegalArgumentException(INVALID_TOKEN); 
		}
		try {
			return new JWTVerifier(secret).verify(token);
		} catch(JWTExpiredException e) {
			throw new TokenExpiredException(e,e.getExpiration());
		} catch(InvalidKeyException | NoSuchAlgorithmException | IllegalStateException | SignatureException | IOException | JWTVerifyException e) {
			throw new IllegalArgumentException(e);
		}
	}
	
	public static boolean isEmpty(String value) {
		return StringUtils.isBlank(value);
	}

}
