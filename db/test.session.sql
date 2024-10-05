show databases;

-- @block
USE vaave

-- @block
show tables

-- @block
Create table Topics (
    id int primary key auto_increment not null,
    topic_name text not null
);

-- @block
INSERT into topics ( topic_name)
values
    ('Sports'),
    ('Science & Technology'),
    ("Arts"),
    ('Politics')

-- @block
SELECT * from Topics

-- @block
Create Table Levels(
    id int primary key auto_increment,
    qlevel varchar(255) not null,
    topic_id int not null,
    foreign key (topic_id) references Topics(id)
);
-- @block
INSERT into levels ( qlevel,topic_id)
values 
    ('Beginner',4),
    ('Intermediate',4),
    ('Professional',4);

-- @block
SELECT * from levels;

-- @block

Select topics.topic_name, levels.qlevel from topics
INNER JOIN levels
where levels.topic_id=topics.id

-- @block
Create table questions(
    id int primary key auto_increment,
    question_text text not null,
    topic_id int not null,
    level_id int not null,
    foreign key (topic_id) references topics(id),
    foreign key (level_id) references levels(id)
)

-- @block
Insert into questions( question_text, topic_id, level_id)
values
('beginner 1 question on politics',4,1),
('beginner 2 question on politics',4,1),
('beginner 3 question on politics',4,1),
('beginner 4 question on politics',4,1),
('Intermediate 1 question on politics',4,2),
('Intermediate 2 question on politics',4,2),
('Intermediate 3 question on politics',4,2),
('Proffessional 1 question on politics',4,3),
('Proffessional 2 question on politics',4,3),
('Proffessional 3 question on politics',4,3)

-- @block
select level_id, question_text from questions
where topic_id =1;

-- @block
create table options(
    id int primary key auto_increment,
    option_text text not null,
    question_id int not null,
    is_correct boolean not null,
    foreign key (question_id) references questions(id)
)

-- @block
Insert into options ( option_text, question_id, is_correct)
Values 
("option 1",31, true),
('option 2',31, false),
('option 3',31, false),
('option 4',31, false),
("option 1",32, true),
('option 2',32, false),
('option 3',32, false),
('option 4',32, false),
("option 1",33, true),
('option 2',33, false),
('option 3',33, false),
('option 4',33, false),
("option 1",34, true),
('option 2',34, false),
('option 3',34, false),
('option 4',34, false),
("option 1",35, true),
('option 2',35, false),
('option 3',35, false),
('option 4',35, false),
("option 1",36, true),
('option 2',36, false),
('option 3',36, false),
('option 4',36, false),
("option 1",37, true),
('option 2',37, false),
('option 3',37, false),
('option 4',37, false),
("option 1",38, true),
('option 2',38, false),
('option 3',38, false),
('option 4',38, false),
("option 1",39, true),
('option 2',39, false),
('option 3',39, false),
('option 4',39, false),
("option 1",40, true),
('option 2',40, false),
('option 3',40, false),
('option 4',40, false)

-- @block
Select * from options

-- @block;
SELECT Questions.id AS question_id, 
           Questions.question_text, 
           Options.id AS option_id, 
           Options.option_text, 
           Options.is_correct
    FROM Questions
    JOIN Topics ON Questions.topic_id = Topics.id
    JOIN Options ON Questions.id = Options.question_id
    WHERE Topics.topic_name ='sports'

-- @block
create table usersdata (
    id int primary key auto_increment,
    useremail varchar(255) not null
)

-- @block
Delete from usersdata where useremail !='NULL'

-- @block
select * from usersdata

-- @block
create table userResponses (
    id int primary key auto_increment,
    user_id int not null,
    topic_id int not null,
    level_id int not null,
    question_id int not null,
    selected_option_id int not null,
    is_correct boolean not null,
    foreign key (user_id) references usersdata(id),
    foreign key (topic_id) references topics(id),
    foreign key (level_id) references levels(id),
    foreign key (question_id) references questions(id),
    foreign key (selected_option_id) references options(id)
    )

-- @block
drop table userResponses

-- @block
Select * from userResponses

-- @block
create table userResult (
    id int primary key auto_increment,
    user_id int not null,   
    topic_id int not null,
    user_score int not null,
    foreign key (user_id) references usersdata(id),
    foreign key (topic_id) references topics(id)
)

-- @block
select * from userResult

