//
//  ViewController.m
//  dalianhua
//
//  Created by Jack on 7/10/13.
//  Copyright (c) 2013 Salmonapps.com. All rights reserved.
//

#import "ViewController.h"
#import "Question.h"

@interface ViewController ()

@end

@implementation ViewController

- (void)viewDidLoad
{
    [super viewDidLoad];
    
    for (int i=0; i<5; i++) {
        NSData *archivedData = [NSKeyedArchiver archivedDataWithRootObject: skipButton];
        UIButton *ans = [NSKeyedUnarchiver unarchiveObjectWithData: archivedData];
        ans.frame = CGRectMake(skipButton.frame.origin.x, 150 + i*ans.frame.size.height, skipButton.frame.size.width, skipButton.frame.size.height);
        [ans addTarget:self action:@selector(tapAnswer:) forControlEvents:UIControlEventTouchUpInside];
        ans.tag = 1000 + i;
        ans.hidden = YES;
        [self.view addSubview:ans];
    }
	
    
    [Question next:^(Question *question, NSError *error) {
        self.current = question;
        [self render];
    }];
    
}

- (void)render {
    //题面
    textView.text = self.current.question;
    
    //隐藏所有button
    for (int i=0; i<5; i++) {
        int tag = 1000 + i;
        UIView *view = [self.view viewWithTag:tag];
        view.hidden = YES;
    }
    
    //答案
    [self.current.answers enumerateObjectsUsingBlock:^(id obj, NSUInteger idx, BOOL *stop) {
        
        NSString *title = [obj objectForKey:@"content"];
        int tag = 1000 + idx;
        UIButton *btn = (UIButton *)[self.view viewWithTag:tag];
        [btn setTitle:title forState:UIControlStateNormal];
        btn.hidden = NO;

    }];
    
}

- (void)tapAnswer:(id)sender {
    
}

- (IBAction)tapSkip:(id)sender {
    [Question next:^(Question *question, NSError *error) {
        self.current = question;
        [self render];
    }];
}

- (IBAction)tapPlay:(id)sender {
    
    if (!self.current.audio_url) {
        return;
    }
    if (!_speaker)
    {
        _speaker = [[MPMoviePlayerController alloc] init];
    }
    
    [_speaker stop];
    [_speaker setContentURL:[NSURL URLWithString:self.current.audio_url]];
    //_speaker.delegate = self;
    [_speaker play];
    
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

@end
