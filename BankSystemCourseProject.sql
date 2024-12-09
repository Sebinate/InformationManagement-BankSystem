CREATE DATABASE BANK_SYSTEM;
USE BANK_SYSTEM;

DROP DATABASE BANK_SYSTEM;

CREATE TABLE IF NOT EXISTS BRANCH
(
	BRANCH_CODE CHAR(4) NOT NULL PRIMARY KEY,
    BRANCH_LOCATION VARCHAR(20) NOT NULL
);

CREATE TABLE IF NOT EXISTS EMPLOYEE
(
	EMP_ID CHAR(4) NOT NULL PRIMARY KEY,
    EMP_NAME VARCHAR(50) NOT NULL,
    EMP_PHONE CHAR(13),
    EMP_PIN CHAR(6) NOT NULL,
    BRANCH_CODE CHAR(4),
    FOREIGN KEY (BRANCH_CODE) 
		REFERENCES BANK_SYSTEM.BRANCH(BRANCH_CODE)
        ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS TRANSACTION
(
	TRANSACT_NUM CHAR(6) NOT NULL PRIMARY KEY,
    TRANSACT_TYPE VARCHAR(12) NOT NULL,
    TRANSACT_AMOUNT DECIMAL(9, 2) NOT NULL,
    EMP_ID CHAR(5),
    CL_ID CHAR(5) NOT NULL,
    ACC_ID CHAR(8) NOT NULL,
    FOREIGN KEY (EMP_ID) 
        REFERENCES BANK_SYSTEM.EMPLOYEE(EMP_ID)
        ON DELETE SET NULL,
    FOREIGN KEY (CL_ID) 
        REFERENCES BANK_SYSTEM.CLIENT(CL_ID)
        ON DELETE CASCADE,
    FOREIGN KEY (ACC_ID) 
        REFERENCES BANK_SYSTEM.ACCOUNT(ACC_ID)
        ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS CLIENT
(
	CL_ID CHAR(4) NOT NULL PRIMARY KEY,
    CL_NAME VARCHAR(50) NOT NULL,
    CL_ADDRESS VARCHAR(50) NOT NULL,
    CL_PHONE CHAR(13),
    CL_EMAIL VARCHAR(50),
    CL_PIN CHAR(6) NOT NULL
);

CREATE TABLE IF NOT EXISTS RECORDS
(
	CL_ID CHAR(4) NOT NULL,
    ACC_ID CHAR(6) NOT NULL,
    PRIMARY KEY (CL_ID, ACC_ID),
    FOREIGN KEY (CL_ID) 
		REFERENCES BANK_SYSTEM.CLIENT(CL_ID)
		ON DELETE CASCADE,
    FOREIGN KEY (ACC_ID) 
        REFERENCES BANK_SYSTEM.ACCOUNT(ACC_ID)
        ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS ACCOUNT
(
	ACC_ID CHAR(6) NOT NULL PRIMARY KEY,
    ACC_STATUS VARCHAR(15) NOT NULL,
    ACC_TYPE VARCHAR(12) NOT NULL
);

CREATE TABLE IF NOT EXISTS CREDIT
(
	ACC_ID CHAR(6) NOT NULL PRIMARY KEY,
    CRD_LIMIT DECIMAL(9,2) NOT NULL,
    CRD_SCR INT NOT NULL,
    CRD_BALANCE DECIMAL(9, 2) NOT NULL,
    CRD_PIN CHAR(6) NOT NULL,
    FOREIGN KEY (ACC_ID) 
        REFERENCES BANK_SYSTEM.ACCOUNT(ACC_ID)
        ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS SAVINGS
(
	ACC_ID CHAR(6) NOT NULL PRIMARY KEY,
    SAV_BAL DECIMAL(9, 2) NOT NULL,
    SAV_RATE DECIMAL(2, 2) NOT NULL,
    SAV_PIN CHAR(6) NOT NULL,
    FOREIGN KEY (ACC_ID) 
        REFERENCES BANK_SYSTEM.ACCOUNT(ACC_ID)
        ON DELETE CASCADE
);